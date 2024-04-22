<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\iSys\Services\VisitBill;
use App\Models\Receptionist\Visit;
use App\Models\Receptionist\Patient;
use App\Models\FinanceModule\Income;
use App\PrintLog;
use TCPDF;
use TCPDF_FONTS;

class VisitController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:rec_vis_show')->only(['index', 'show']);
        $this->middleware('permission:rec_vis_create')->only(['create', 'store']);
        $this->middleware('permission:rec_vis_edit')->only(['edit', 'update']);
        $this->middleware('permission:rec_vis_delete')->only(['destroy']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $visits = Visit::with('doctor', 'cashier', 'patient')
            ->latest()
            ->paginate($limit);

        return view('receptionist-module.visit.index', compact('visits'));
    }

    public function show(Visit $visit)
    {
        $visit->load(['cashier', 'patient', 'patient.prescriptions', 'patient.experiments', 'doctor', 'profit']);
        // dd($visit);
        return view('receptionist-module.visit.show', compact('visit'));
    }

    public function create()
    {
        return view('receptionist-module.visit.create');
    }

    public function store()
    {

        $this->validate(request(), [
            'doctor_id' => 'required',
            'patient_id' => 'required_without:name,age',
            'name' => 'required_without:patient_id|min:3',
            'age' => 'required_without:patient_id|numeric',
            'sex' => 'required_without:patient_id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|gt:-1',
            'currency_id' => 'required|numeric',
            'recipient' => 'required',
            'discount' => 'nullable|numeric|between:0,100|required_with:member_id',
            'member_id' => 'nullable|numeric|required_with:discount',
        ]);

        \DB::beginTransaction();

        // find or create patient
        $patient = new Patient;

        if (request()->has('patient_id')) {
            $patient = Patient::find(request()->patient_id);
            // dd($patient);
        } else {

            $record_no = Patient::generateRecordNo();

            $patient = Patient::create([
                'name' => request()->name,
                'age' => request()->age,
                'sex' => request()->sex,
                'record_no' => $record_no,
                'phone_no' => request()->phone_no,
                'address' => request()->address,
                'tazkira' => request()->tazkira,
                'registrar_id' => auth()->id(),
                'photo' => request()->hasFile('img_path') ?
                    request()->img_path->move('patient_pic', request()->name . $record_no . '.' . request()->img_path->getClientOriginalExtension()) : null,
            ]);
        }

        // request()->request->add(['class_id' => $class->id, 'registrar_id' => auth()->id()]);

        $newVisit = Visit::create([
            'patient_id' => $patient->id,
            'doctor_id' => request()->doctor_id,
            'cashier_id' => auth()->id(),
            'discount' => request()->discount,
            'membership_id' => request()->member_id,
        ]);

        $discoutAmount = 0;
        if (request()->has('discount'))
            $discoutAmount = \App\iSys\Services\IncomeFormatter::toAmount(request()->amount, request()->discount);

        $newIncome = new Income([
            'payment_date' => request()->payment_date,
            'amount' => request()->amount - $discoutAmount,
            'currency_id' => request()->currency_id,
            'recipient' => request()->recipient,
            'tax' => config("iSys.tax.visit", config("iSys.tax.default")),
            'registrar_id' => auth()->id(),
            'approved_user' => auth()->id(),
            'is_approved' => 1,
            'is_countable_tax' => 0,
        ]);

        // save the all incomes
        $newVisit->profit()->save($newIncome);

        \DB::commit();

        return redirect(route('visit.show', [$newVisit->id]))->with([
            'alert' => "created",
            'class' => 'alert-info'
        ]);
    }

    public function edit(Visit $visit)
    {
        $visit->load(['patient', 'doctor', 'profit']);
        return view('receptionist-module.visit.edit', compact('visit'));
    }

    public function update(Visit $visit)
    {
        $this->validate(request(), [
            'doctor_id' => 'required',
            'patient_id' => 'required_without:name,age',
            'name' => 'required_without:patient_id|min:3',
            'age' => 'required_without:patient_id|numeric',
            'sex' => 'required_without:patient_id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|gt:1',
            'currency_id' => 'required|numeric',
            'recipient' => 'required',
            'discount' => 'nullable|numeric|between:0,100|required_with:member_id',
            'member_id' => 'nullable|numeric|required_with:discount',
        ]);

        \DB::beginTransaction();

        // find or create patient
        $patient = new Patient;

        if (request()->has('patient_id')) {
            $patient = $visit->patient_id != request()->patient_id ? Patient::find(request()->patient_id) : $visit->patient;
            $visit->patient_id = $patient->id;
            // dd($patient);
        } else {

            $patient = $visit->patient;

            $patient->update(request()->only(['name', 'age', 'sex', 'phone_no', 'address', 'tazkira']));

            if (request()->hasFile('img_path'))
                $patient->update([
                    'photo' => request()->img_path->move('patient_pic', request()->name . Str::uuid()->toString() . '.' . request()->img_path->getClientOriginalExtension())
                ]);
        }

        // $visit->save();

        $payableAmount = request()->amount;
        $discoutAmount = 0;
        if (request()->has('discount')) {

            // the doctor has been changed
            if ($visit->doctor_id != request()->doctor_id)
                $discoutAmount = \App\iSys\Services\IncomeFormatter::toAmount(request()->amount, request()->discount);

            // only the discount change not doctor
            if (request()->discount != $visit->discount && $visit->doctor_id == request()->doctor_id) {
                $payableAmount = $visit->doctor->visit_fee;
                $discoutAmount = \App\iSys\Services\IncomeFormatter::toAmount($visit->doctor->visit_fee, request()->discount);
            }

            $payableAmount = $payableAmount - $discoutAmount;
        }

        $visit->doctor_id = request()->doctor_id;
        $visit->discount = request()->discount;
        $visit->membership_id = request()->member_id;
        $visit->save();

        $profit = $visit->profit;
        $profit->payment_date = request()->payment_date;
        $profit->amount = $payableAmount;
        $profit->currency_id = request()->currency_id;
        $profit->recipient = request()->recipient;
        $profit->save();

        \DB::commit();

        return redirect(route('visit.show', [$visit->id]))->with([
            'alert' => "edited",
            'class' => 'alert-brand'
        ]);
    }

    public function destroy(Visit $visit)
    {
        \DB::beginTransaction();

        $visit->profit->delete();
        $visit->delete();
        
        \DB::commit();
        
        return redirect(route('visit.index'))->with([
            'alert' => "deleted",
            'class' => 'alert-danger'
        ]);

    }

    public function print(Visit $visit)
    {

        $visit->load(['cashier', 'patient', 'doctor', 'profit']);

        $pdf = new VisitBill();

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO);

        // Add a page
        $pdf->AddPage();
        // set some text for example
        $pdf->Ln(25);

        // set some language-dependent strings (optional)
        $pdf->setLanguageArray(['a_meta_language' => 'fa']);

        // convert TTF font to TCPDF format and store it on the fonts folder
        $fontname = TCPDF_FONTS::addTTFfont('fonts/Sahel.ttf', 'TrueTypeUnicode', '', 96);
        // $pdf->SetFont('dejavusans', '', 15);

        // use the font
        $pdf->SetFont($fontname, '', 14, '', false);

        $title = '<table>
            <tr>
                <th>Doctor visit payment bill</th>
                <th>بل پرداخت ویزیت داکتر</th>
            </tr>
        </table>';
        // $pdf->SetFont('times', '', 20);
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->Ln(3);

        $pdf->SetFontSize(12);
        $htmlRow1 = '<table>
            <tr>
                <th> اسم داکتر: ' . $visit->doctor->name . '</th>
                <th>نمبر ریکورد: ' . $visit->patient->record_no . '</th>
                <th> اسم مریض: ' . $visit->patient->name . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
            <tr>
                <th> تخصص داکتر: ' . $visit->doctor->specialist . '</th>
                <th> سن: ' . $visit->patient->age . '</th>
                <th> جنسیت: ' . __("reception.{$visit->patient->sex}") . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'R');


        $htmlRow3 = '<table>
            <tr>
                <th> ساعت ثبت: ' . $visit->created_at->format('g:s A') . '</th>
                <th> تاریخ ثبت: ' . $visit->created_at->format('Y/m/d')  . '</th>
                <th> خزانه دار: ' . $visit->cashier->name_dr . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');
        // output the HTML content

        $htmlRow4 = '<table>
            <tr>
                <th></th>
                <th> مقدار قابل پرداخت: ' . $visit->profit->totalAmount . ' ' . $visit->profit->currency->label_dr . '</th>
                <th> فیس داکتر: ' . $visit->doctor->visit_fee . ' ' . $visit->profit->currency->label_dr . '</th>
            </tr>
        </table>';

        // $htmlRow4 = '<table>
        //     <tr>
        //         <th> مقدار قابل پرداخت: ' . $visit->profit->totalAmount . ' ' . $visit->profit->currency->label_dr . '</th>
        //         <th> مالیات: ' . $visit->profit->taxes . ' ' . $visit->profit->currency->label_dr . '</th>
        //         <th> فیس داکتر: ' . $visit->doctor->visit_fee . ' ' . $visit->profit->currency->label_dr . '</th>
        //     </tr>
        // </table>';

        $pdf->writeHTML($htmlRow4, true, false, true, false, 'R');
        // output the HTML content

        $pdf->Ln(30);
        $addr = '<table>
            <tr>
                <th> شماره های تماس: 0777757523 - 0785790890</th>
                <th colspan="2"> آدرس: کابل، چهارراهی سر سبزی، جوار هوتل شام پارس، شفاخانه آریا سیتی.</th>
            </tr>
        </table>';
        $pdf->SetFontSize(8);
        $pdf->writeHTML($addr, true, false, true, false, 'R');

        $pdf->Image('img/print-header.png', 0, 135, 210, 30, 'PNG', '', '', true);

        $pdf->SetFontSize(15);

        $pdf->Ln(42);
        $title = '<table>
            <tr>
                <th>Doctor visit payment bill</th>
                <th>بل پرداخت ویزیت داکتر</th>
            </tr>
        </table>';
        // $pdf->SetFont('times', '', 20);
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->Ln(3);

        $pdf->SetFontSize(12);
        $htmlRow1 = '<table>
            <tr>
                <th> اسم داکتر: ' . $visit->doctor->name . '</th>
                <th>نمبر ریکورد: ' . $visit->patient->record_no . '</th>
                <th> اسم مریض: ' . $visit->patient->name . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
            <tr>
                <th> تخصص داکتر: ' . $visit->doctor->specialist . '</th>
                <th> سن: ' . $visit->patient->age . '</th>
                <th> جنسیت: ' . __("reception.{$visit->patient->sex}") . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'R');


        $htmlRow3 = '<table>
            <tr>
                <th> ساعت ثبت: ' . $visit->created_at->format('g:s A') . '</th>
                <th> تاریخ ثبت: ' . $visit->created_at->format('Y/m/d')  . '</th>
                <th> خزانه دار: ' . $visit->cashier->name_dr . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');
        // output the HTML content

        $htmlRow4 = '<table>
            <tr>
                <th></th>
                <th> مقدار قابل پرداخت: ' . $visit->profit->totalAmount . ' ' . $visit->profit->currency->label_dr . '</th>
                <th> فیس داکتر: ' . $visit->doctor->visit_fee . ' ' . $visit->profit->currency->label_dr . '</th>
            </tr>
        </table>';

        // $htmlRow4 = '<table>
        //     <tr>
        //         <th> مقدار قابل پرداخت: ' . $visit->profit->totalAmount . ' ' . $visit->profit->currency->label_dr . '</th>
        //         <th> مالیات: ' . $visit->profit->taxes . ' ' . $visit->profit->currency->label_dr . '</th>
        //         <th> فیس داکتر: ' . $visit->doctor->visit_fee . ' ' . $visit->profit->currency->label_dr . '</th>
        //     </tr>
        // </table>';

        $pdf->writeHTML($htmlRow4, true, false, true, false, 'R');
        // output the HTML content

        $pdf->Ln(30);
        $addr = '<table>
            <tr>
                <th> شماره های تماس: 0777757523 - 0785790890</th>
                <th colspan="2"> آدرس: کابل، چهارراهی سر سبزی، جوار هوتل شام پارس، شفاخانه آریا سیتی.</th>
            </tr>
        </table>';
        $pdf->SetFontSize(8);
        $pdf->writeHTML($addr, true, false, true, false, 'R');

        // save printed log
        PrintLog::create([
            'printable_id' => $visit->id,
            'printable_type' => Visit::class,
            'printed_user' => auth()->id()
        ]);

        $pdf->Output('testPrint/example_001.pdf');
    }

    public function search()
    {
        if (request()->ajax()) {

            $visits = Visit::query();
            $constraints = 0;

            if (request()->filled('cashier_id')) {
                $visits->where('cashier_id', request()->cashier_id);
                $constraints++;
            }
            if (request()->filled('doctor_id')) {
                $visits->where('doctor_id', request()->doctor_id);
                $constraints++;
            }
            if (request()->filled('discount')) {
                $visits->where('discount', request()->discount_equation, request()->discount);
                $constraints++;
            }
            if (request()->filled('from_date')) {
                $visits->whereDate('created_at', request()->from_date_equation, request()->from_date);
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $visits->whereDate('created_at', request()->till_date_equation, request()->till_date);
                $constraints++;
            }
            if (request()->filled('name')) {
                $name = request()->name;
                $visits->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
                $constraints++;
            }
            if (request()->filled('record_no')) {
                $record_no = request()->record_no;
                $visits->whereHas('patient', function ($query) use ($record_no) {
                    $query->where('record_no', $record_no);
                });
                $constraints++;
            }
            if (request()->filled('phone_no')) {
                $phone_no = request()->phone_no;
                $visits->whereHas('patient', function ($query) use ($phone_no) {
                    $query->where('phone_no', 'like', '%' . $phone_no . '%');
                });
                $constraints++;
            }
            if (request()->filled('phone_no')) {
                $phone_no = request()->phone_no;
                $visits->whereHas('patient', function ($query) use ($phone_no) {
                    $query->where('phone_no', 'like', '%' . $phone_no . '%');
                });
                $constraints++;
            }
            if (request()->filled('age')) {
                $age = request()->age;
                $age_equation = request()->age_equation;
                $visits->whereHas('patient', function ($query) use ($age, $age_equation) {
                    $query->where('age', $age_equation, $age);
                });
                $constraints++;
            }
            if (request()->filled('doctor_fees')) {
                $doctor_fees = request()->doctor_fees;
                $doctor_fees_equation = request()->fee_equation;
                $visits->whereHas('doctor', function ($query) use ($doctor_fees, $doctor_fees_equation) {
                    $query->where('visit_fee', $doctor_fees_equation, $doctor_fees);
                });
                $constraints++;
            }

            $visits->latest();
            // return $visits->dump();
            if ($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $visits
                ->with([
                    'doctor:id,first_name,last_name,visit_fee',
                    'patient',
                    'profit',
                    'cashier:id,name as name'
                ])->get() : $visits
                ->with([
                    'doctor:id,first_name,last_name,visit_fee',
                    'patient',
                    'profit',
                    'cashier:id,name_dr as name'
                ])->get();
        }

        return view('receptionist-module.visit.filter');
    }
}
