<?php

namespace App\Http\Controllers\LabModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\iSys\Services\ExperimentBill;
use App\Models\LabModule\Test;
use App\Models\LabModule\Experiment;
use App\Models\Receptionist\Patient;
use TCPDF;
use TCPDF_FONTS;

class ExperimentController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:lab_exp_show')->only(['index', 'show']);
        $this->middleware('permission:lab_exp_create')->only(['create', 'store']);
        $this->middleware('permission:lab_exp_edit')->only(['edit', 'update']);
        $this->middleware('permission:lab_exp_delete')->only(['destroy']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $experiments = Experiment::with(['patient', 'doctor', 'profit', 'profit.currency'])
            ->withCount(['tests'])
            ->latest()
            ->paginate($limit);

        return view('lab-module.experiment.index', compact('experiments'));
    }

    public function show(Experiment $experiment)
    {
        $experiment->load([
            'doctor',
            'profit',
            'profit.currency',
            'patient',
            'registrar',
            'attachments',
            'tests'
        ]);

        return view('lab-module.experiment.show', compact('experiment'));
    }

    public function create()
    {
        return view('lab-module.experiment.create');
    }

    public function store()
    {

        $this->validate(request(), [
            'patient_id' => 'required',
            'doctor_id' => 'required_without:same_doctor',
            'discount' => 'nullable|numeric|between:0,100|required_with:member_id',
        ]);

        \DB::beginTransaction();
        
        $patient = Patient::find(request()->patient_id);

        $newExperiment = Experiment::create([
            'patient_id' => request()->patient_id,
            'doctor_id' => request()->has('doctor_id')
                ? request()->doctor_id
                : $patient->visits()->latest()->first()->doctor_id,
            'status' => 0,
            'record_no' => Experiment::generateRecordNo(),
            'registrar_id' => auth()->id(),
            'is_approved' => false,
            'discount' => request()->discount,
            'membership_id' => request()->member_id,
        ]);

        //the items
        foreach (request()->items as $item) {

            //get the medicine
            $test = Test::find($item['test_id']);

            // attach the medicine to list
            $newExperiment->tests()->attach($test, [
                // 'medicine_id' => $medicine->id,
                'price' => $test->price,
                'results' => $test->subTests()->exists() ? null : nl2br($test->description_dr),
                'currency_id' => $test->currency_id,
                'experimentor' => auth()->user()->name,
            ]);
        }

        $paymentAmount = $newExperiment->tests->sum('pivot.price');
        $discoutAmount = 0;
        if (request()->has('discount'))
            $discoutAmount = \App\iSys\Services\IncomeFormatter::toAmount($paymentAmount, request()->discount);

        // Save the profit to income
        $income = $newExperiment->profit()->save(new \App\Models\FinanceModule\Income([
            'payment_date' => date('Y-m-d'),
            'amount' => $paymentAmount - $discoutAmount,
            'currency_id' => $newExperiment->tests()->latest()->first()->currency_id,
            'recipient' => app()->isLocale('en') ? auth()->user()->name : auth()->user()->name_dr,
            'tax' => config("iSys.tax.experiment", config("iSys.tax.default")),
            'registrar_id' => auth()->id(),
            'is_approved' => false,
        ]));

        // Save the approvable
        $newExperiment->approve()->save(new \App\Approvable([
            'record_no' => $patient->record_no .' ('. $patient->name .')',
            'type' => 'new',
            'amount' => $newExperiment->profit->totalAmount,
            'currency_id' => $income->currency_id,
            'is_approved' => null,
        ]));

        \DB::commit();

        return redirect(route('experiment.show', [$newExperiment->id]))
            ->with([
                'alert' => "created",
                'class' => 'alert-info'
            ]);
    }

    public function edit(Experiment $experiment)
    {
        $experiment->load('patient');
        return view('lab-module.experiment.edit', compact('experiment'));
    }

    public function update(Experiment $experiment)
    {

        $this->validate(request(), [
            'patient_id' => 'required',
            'doctor_id' => 'required',
        ]);

        \DB::beginTransaction();

        $oldTests = $experiment->tests()->get()->toArray();
        $oldProfit = $experiment->profit->toArray();

        $saveState = ['old' => [
            'tests' => [
                    'collection' => $oldTests,
                    'pivot' => 'experiment_test'
                ],
            'profit' => $oldProfit,
            ]
        ];

        $experiment->update([
            'patient_id' => request()->patient_id,
            'doctor_id' => request()->doctor_id,
            'status' => request()->status,
        ]);

        $oldTests = request()->oldItems;
        
        foreach ($experiment->tests as $test) {

            if(!$oldTests || !array_key_exists($test->id, $oldTests))
                // dd($oldTests);
                // sync the test
                $experiment->tests()->detach($test->id);
        }

        if(request()->has('items'))
            //the items
            foreach (request()->items as $item) {

                //get the medicine
                $test = Test::find($item['test_id']);

                // attach the medicine to list
                $experiment->tests()->attach($test, [
                    // 'medicine_id' => $medicine->id,
                    'price' => $test->price,
                    'results' => $test->description_dr,
                    'currency_id' => $test->currency_id,
                    'experimentor' => auth()->user()->name,
                ]);
            }

        $oldIncomeAmount = $experiment->profit->totalAmount;
        // dd($experiment->tests->sum('pivot.price'));

        $profit = $experiment->profit;
        $profit->amount = $experiment->tests()->get()->sum('pivot.price');
        $profit->is_approved = 0;
        $profit->save();

        $saveState += ['new' => [
            'tests' => [
                    'collection' => $experiment->tests()->get()->toArray(),
                    'pivot' => 'experiment_test'
                ],
            'profit' => $experiment->profit->toArray(),
            ]
        ];

        $experiment->approve()->save(new \App\Approvable([
            'record_no' => $experiment->patient->record_no .' ('. $experiment->patient->name .')',
            'type' => $oldIncomeAmount >= $profit->totalAmount ? 'refund' : 'payment',
            'amount' => abs($oldIncomeAmount - $profit->totalAmount),
            'currency_id' => $profit->currency_id,
            'is_approved' => null,
            'state' => $saveState,
        ]));

        if($oldIncomeAmount != $profit->totalAmount)
            $experiment->update(['is_approved' => 0]);

        \DB::commit();

        // return view('pharmacist-module.prescription.show',[$newExperiment->id]);
        return redirect(route('experiment.show', [$experiment->id]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand'
            ]);
    }

    public function destroy(Experiment $experiment)
    {
        \DB::beginTransaction();

        $experiment->profit->delete();
        $experiment->delete();

        \DB::commit();

        return redirect(route('experiment.index'))->with([
            'alert' => "deleted",
            'class' => 'alert-danger'
        ]);
    }

    public function refund(Experiment $experiment)
    {
        \DB::beginTransaction();

        $oldTests = $experiment->tests()->get()->toArray();
        $oldProfit = $experiment->profit->toArray();

        $saveState = ['old' => [
            'tests' => [
                    'collection' => $oldTests,
                    'pivot' => 'experiment_test'
                ],
            'profit' => $oldProfit,
            ]
        ];

        $experiment->tests()->detach();
        
        $experiment->approve()->save(new \App\Approvable([
            'record_no' => $experiment->patient->record_no .' ('. $experiment->patient->name .')',
            'type' => 'refund',
            'amount' => $experiment->profit->totalAmount,
            'currency_id' => $experiment->profit->currency_id,
            'is_approved' => null,
            'state' => $saveState,
        ]));

        $experiment->profit()->update(['amount' => 0, 'is_approved' => 0]);
        $experiment->update(['status' => 0]);

        \DB::commit();

        return back()->with([
            'alert' => "performed",
            'class' => 'alert-info'
        ]);
    }

    public function ajaxFilter()
    {
        $tests = Test::select('id', 'name')
            ->where('name', 'like', '%' . request()->name . '%')
            ->get()
            ->toJson();
        return $tests;
    }

    public function print(Experiment $experiment)
    {

        $experiment->load(['registrar', 'patient', 'doctor', 'tests', 'tests.currency', 'profit']);

        if(request()->exists('result'))
            return $this->printBill($experiment);

        $pdf = new ExperimentBill();

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO);
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // Add a page
        $pdf->AddPage();
        // set some text for example
        $pdf->Ln(25);

        // set some language-dependent strings (optional)
        $pdf->setLanguageArray(['a_meta_language' => 'fa']);

        $fontname = TCPDF_FONTS::addTTFfont('fonts/Sahel.ttf', 'TrueTypeUnicode', '', 96);

        // use the font
        $pdf->SetFont($fontname, '', 14, '', false);

        $title = '<table>
            <tr>
                <th><strong>Experiments payment bill</strong></th>
                <th><strong>بل پرداخت آزمایش ها</strong></th>
            </tr>
        </table>';
        // $pdf->SetFont('times', '', 20);
        $pdf->writeHTML($title, true, false, true, false, 'C');


        $pdf->SetFontSize(10);
        $htmlRow1 = '<table>
            <tr>
                <th> نمبر ریکورد آزمایش: ' . $experiment->record_no . '</th>
                <th> نمبر ریکورد مریض: ' . $experiment->patient->record_no . '</th>
                <th> اسم مریض: ' . $experiment->patient->name . '</th>
                </tr>
            </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
                <tr>
                <th> تخصص داکتر: ' . $experiment->doctor->specialist . '</th>
                <th> اسم داکتر: ' . $experiment->doctor->name . '</th>
                <th> سن: ' . $experiment->patient->age . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'R');


        $htmlRow3 = '<table>
            <tr>
                <th> ساعت ثبت: ' . $experiment->created_at->format('g:s A') . '</th>
                <th> تاریخ ثبت: ' . $experiment->created_at->format('Y/m/d')  . '</th>
                <th> ثبت کننده : ' . $experiment->registrar->name_dr . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');

        $htmlRow3 = '<table>
            <tr>
                <th><strong>فهرست تست های انجام شده</strong></th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');

        $tableHead = '
            <table cellspacing="0" cellpadding="3" border="0.5">
                <tr>
                    <th width="20%">قیمت مجموع</th>
                    <th width="20%">مالیات</th>
                    <th width="50%">آزمایش</th>
                    <th width="10%">#</th>
                </tr>
        ';

        // $tableHead = '
        //     <table cellspacing="0" cellpadding="3" border="1">
        //         <tr>
        //             <th>قیمت مجموع</th>
        //             <th>مالیات</th>
        //             <th>تشریحات</th>
        //             <th>نتایج</th>
        //             <th>آزمایش</th>
        //             <th>#</th>
        //         </tr>
        // ';

        $tablebody ='';

        foreach($experiment->tests as $key => $test){
            $tablebody .= '
                <tr>
                <td> ... </td>
                <td> ... </td>
                <td>' .$test->name. '</td>
                <td>' .++$key. '</td>
                </tr>
            ';
            // $tablebody .= '
            //     <tr>
            //     <td> ... </td>
            //     <td> ... </td>
            //     <td>' .$test->pivot->description. '</td>
            //     <td>' .$test->pivot->results. '</td>
            //     <td>' .$test->name. '</td>
            //     <td>' .++$key. '</td>
            //     </tr>
            // ';
        }

        $total = $experiment->profit->totalAmount . ' ' . (app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr) ;
        $tax = $experiment->profit->taxes . ' ' . (app()->isLocale('en') ? $experiment->profit->currency->label_en : $experiment->profit->currency->label_dr) ;

        $tablebody .= '
            <tr>
                <td>' . $total . '</td>
                <td> ... </td>
                <td colspan="2"></td>
            </tr>
        </table>';

        // $tablebody .= '
        //     <tr>
        //         <td>' . $total . '</td>
        //         <td>' .$tax. '</td>
        //         <td colspan="2"></td>
        //     </tr>
        // </table>';

        $pdf->writeHTML($tableHead . $tablebody, true, false, true, false, 'R');

        $pdf->Output('testPrint/example_001.pdf');
    }

    public function printBill(Experiment $experiment)
    {
        $view = view('lab-module.experiment.print-result', compact('experiment'));
        
        $lang = app()->getLocale();

        $mpdf = new \Mpdf\Mpdf([
                'mode' => 'UTF-8',
                'format' => 'A4',
                'margin_header' => 40,     // 30mm not pixel
                'margin_footer' => 10,
            ]);
        $mpdf->SetMargins(0, 0, 68);
        $mpdf->SetHTMLHeader('<span style="width:100%; height:200px">&nbsp;</span>', true);

        app()->setLocale('en');
        $mpdf->WriteHTML($view->render());
        app()->setLocale($lang);

        $mpdf->Output();

        // $pdf = app()->make('dompdf.wrapper');
        // $pdf->loadView('lab-module.experiment.print-result', compact('experiment'));
        // return $pdf->stream();
    }

    public function printBillOld(Experiment $experiment)
    {

        $pdf = new TCPDF();

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 70, PDF_MARGIN_RIGHT);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 40);

        // Add a page
        $pdf->AddPage();
        // set some text for example
        // $pdf->Ln(25);

        // set some language-dependent strings (optional)
        $pdf->setLanguageArray(['a_meta_language' => 'fa']);

        $fontname = TCPDF_FONTS::addTTFfont('fonts/Sahel.ttf', 'TrueTypeUnicode', '', 96);

        // use the font
        $pdf->SetFont($fontname, '', 9, '', false);

        $htmlRow1 = '<table>
            <tr>
                <th> '. __('lab.lab_expRecord_no') .': ' . $experiment->record_no . '</th>
                <th> '. __('lab.lab_patRecord_no') .': ' . $experiment->patient->record_no . '</th>
                <th> '. __('reception.pat_name') .': ' . $experiment->patient->name . '</th>
                <th> '. __('reception.pat_age') .': ' . $experiment->patient->age . '</th>
                </tr>
            </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'L');

        $htmlRow2 = '<table>
                <tr>
                <th>' . __('reception.vis_doctors') .' : ' . $experiment->doctor->name . '</th>
                <th>' . __('reception.docy_specialze') .': ' . $experiment->doctor->specialist . '</th>
                <th>' . __('reception.sex') .': ' . $experiment->patient->sex . '</th>
                <th>' . __('global.date') .': ' . $experiment->created_at->format('Y-m-d g:s A') . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'L');


        $tableHead = '
            <table cellspacing="0" cellpadding="3" border="0.5">
                <tr>
                    <th width="30%">Description</th>
                    <th width="40%">Reference Range</th>
                    <th width="30%">Patient Value</th>
                </tr>
        ';
        $tablebody ='';

        foreach($experiment->tests as $key => $test){
            //dd(nl2br($test->pivot->results));
            $tablebody .= '
                <tr>
                <td>' .$test->name. '</td>
                <td>' .nl2br($test->pivot->results). '</td>
                <td>' .nl2br(substr($test->pivot->description, 1)). '</td>
                </tr>
            ';
            
            // $tablebody .= '
            //     <tr>
            //     <td>' .$test->name. '</td>
            //     <td>' .nl2br($test->pivot->results). '</td>
            //     <td>' .nl2br($test->pivot->description). '</td>
            //     </tr>
            // ';
        }

        $tablebody .= '</table>';

        $pdf->writeHTML($tableHead . $tablebody, true, false, true, false, 'L');

        $pdf->Output('testPrint/example_002.pdf');
    }

    public function filter()
    {
        if (request()->ajax()) {

            $experiments = Experiment::query();
            $constraints = 0;

            if (request()->filled('registrar_id')) {
                $experiments->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('doctor_id')) {
                $experiments->where('doctor_id', request()->doctor_id);
                $constraints++;
            }
            if (request()->filled('exp_record_no')) {
                $experiments->where('record_no', request()->exp_record_no);
                $constraints++;
            }
            if (request()->filled('from_date')) {
                $experiments->whereDate('created_at', request()->from_date_equation, request()->from_date);
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $experiments->whereDate('created_at', request()->till_date_equation, request()->till_date);
                $constraints++;
            }
            if (request()->filled('name')) {
                $name = request()->name;
                $experiments->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
                $constraints++;
            }
            if (request()->filled('record_no')) {
                $record_no = request()->record_no;
                $experiments->whereHas('patient', function ($query) use ($record_no) {
                    $query->where('record_no', $record_no);
                });
                $constraints++;
            }
            if (request()->filled('amount')) {
                $amount = request()->amount;
                $amount_equation = request()->amount_equation;
                $experiments->whereHas('profit', function ($query) use ($amount, $amount_equation) {
                    $query->where('amount', $amount_equation, $amount);
                });
                $constraints++;
            }

            $experiments->latest();
            // return $experiments->dump();
            if($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $experiments
                    ->with([
                        'doctor:id,first_name,last_name',
                        'patient:id,name,record_no',
                        'profit',
                        'registrar:id,name as name',
                        'profit.approvedBy:id,name as name',
                        ])->get() :
                $experiments
                    ->with([
                        'doctor:id,first_name,last_name',
                        'patient:id,name,record_no',
                        'profit',
                        'registrar:id,name_dr as name',
                        'profit.approvedBy:id,name_dr as name',
                        ])->get() ;
        }

        return view('lab-module.experiment.filter');
    }
    
    public function form(Experiment $experiment)
    {
        //load experment relationships
        $experiment->load([
            'doctor',
            'profit',
            'profit.currency',
            'patient',
            'registrar',
            'attachments',
            'tests'
        ]);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/test_sample.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        //write the data
        $sheet->setCellValue('B11', $experiment->record_no);
        $sheet->setCellValue('C11', optional($experiment->patient)->name . ' (' .optional($experiment->patient)->record_no .')');
        $sheet->setCellValue('D11', (optional($experiment->patient)->sex == 'm' ? 'Male' : 'Female'));
        
        $sheet->setCellValue('B13', optional($experiment->doctor)->first_name . ' ' . optional($experiment->doctor)->last_name);
        $sheet->setCellValue('C13', optional($experiment->created_at)->format('Y/m/d g:s A'));
        $sheet->setCellValue('D13', (optional($experiment->patient)->age . ' Years'));

        // write subtests
        $rows = 16;
        foreach($experiment->tests as $test){
            if($test->subTests()->exists())
                foreach($test->subTests as $sub){
                    $sheet->setCellValue('B'. $rows, $sub->name);
                    $lines = explode("\n", $sub->range);
                    foreach($lines as $line){
                        $sheet->setCellValue('C'. $rows, $line);
                        $rows++;
                    }
                }
                
            else{
                $sheet->setCellValue('B'. $rows, $test->name);
                $lines = explode("\n", $test->description_dr);
                foreach($lines as $line){
                    $sheet->setCellValue('C'. $rows, $line);
                    $rows++;
                }
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save('temp/test_sample.xlsx');

        $fileName = str_replace(' ', '-', $experiment->record_no . '-' . optional($experiment->patient)->name . '(' .optional($experiment->patient)->record_no .')');

        return response()->download('temp/test_sample.xlsx', $fileName .'.xlsx');
    }

    public function search()
    {

        if (request()->ajax())
            return Experiment::search(request()->term)->query(function ($builder) {
                $builder->with('patient');
            })
                ->get();
    }
}
