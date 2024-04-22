<?php

namespace App\Http\Controllers\Receptionist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receptionist\Emergency;
use App\Models\FinanceModule\DiverseIncome;
use App\Models\FinanceModule\Income;
use App\iSys\Services\VisitBill;
use TCPDF;
use TCPDF_FONTS;

class EmergencyController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:rec_emr_show')->only(['index', 'show']);
        $this->middleware('permission:rec_emr_create')->only(['create', 'store']);
        $this->middleware('permission:rec_emr_edit')->only(['edit', 'update']);
        $this->middleware('permission:rec_emr_destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $list = Emergency::with(['profit', 'profit.currency'])
            ->latest()
            ->paginate($limit);

        // dd($doctors);

        return view('receptionist-module.emergency.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('receptionist-module.emergency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'reason' => 'required',
            'amount' => 'required',
            'currency_id' => 'required',
            'patient_name' => 'required_without:patient_id',
            'discount' => 'nullable|numeric|between:0,100|required_with:member_id',
        ]);

        $patient = null;
        if(request()->filled('patient_id'))
            $patient = \App\Models\Receptionist\Patient::find(request()->patient_id);

        // dd($patient);
        \DB::beginTransaction();
        $newEmergency = Emergency::create([
            'reason' => request()->reason,
            'patient_id' => request()->patient_id,
            'patient_name' => $patient ? $patient->name : request()->patient_name,
            'doctor_id' => request()->doctor_id,
            'registrar_id' => auth()->id(),
            'discount' => request()->discount,
            'membership_id' => request()->member_id,
        ]);

        $discoutAmount = 0;
        if (request()->has('discount'))
            $discoutAmount = \App\iSys\Services\IncomeFormatter::toAmount(request()->amount, request()->discount);


        $newIncome = new Income([
            'payment_date' => now()->format('Y-m-d'),
            'amount' => request()->amount - $discoutAmount,
            'currency_id' => request()->currency_id,
            'recipient' => auth()->user()->name_dr,
            'tax' => config("iSys.tax.visit", config("iSys.tax.default")),
            'registrar_id' => auth()->id(),
            'approved_user' => auth()->id(),
            'is_approved' => 1,
        ]);
        
        // save the all emer$emergency
        $newEmergency->profit()->save($newIncome);

        \DB::commit();

        return redirect(route('emergency.show', [$newEmergency->id]))->with([
            'alert' => "created",
            'class' => 'alert-info'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Emergency $emergency)
    {
        $emergency->load('profit');
        return view('receptionist-module.emergency.show', compact('emergency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Emergency $emergency)
    {
        $emergency->load('profit');
        return view('receptionist-module.emergency.edit', compact('emergency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emergency $emergency)
    {
        $this->validate(request(), [
            'reason' => 'required',
            'amount' => 'required',
            'currency_id' => 'required',
            'patient_name' => 'required',
        ]);

        \DB::beginTransaction();
        $emergency->update([
            'reason' => request()->reason,
            'patient_name' => request()->patient_name,
            'doctor_id' => request()->doctor_id,
        ]);

        $emergency->profit()->update([
            'amount' => request()->amount,
            'currency_id' => request()->currency_id,
        ]);

        \DB::commit();

        return redirect(route('emergency.show', [$emergency->id]))->with([
            'alert' => "created",
            'class' => 'alert-info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter()
    {
        if (request()->ajax()) {

            $emergency = Emergency::query();
            $constraints = 0;

            if (request()->filled('registrar_id')) {
                $emergency->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('from_date')) {
                $emergency->whereDate('created_at', request()->from_date_equation, request()->from_date);
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $emergency->whereDate('created_at', request()->till_date_equation, request()->till_date);
                $constraints++;
            }
            if (request()->filled('reason')) {
                $emergency->where('reason', 'like', '%' . request()->reason . '%');
                $constraints++;
            }
            if (request()->filled('patient_name')) {
                $emergency->where('patient_name', 'like', '%' . request()->patient_name . '%');
                $constraints++;
            }
            if (request()->filled('recipient')) {
                $recipient = request()->recipient;
                $emergency->whereHas('profit', function ($query) use ($recipient) {
                    $query->where('recipient', 'like', '%' . $recipient . '%');
                });
                $constraints++;
            }
            if (request()->filled('amount')) {
                $amount = request()->amount;
                $emergency->whereHas('profit', function ($query) use ($amount) {
                    $query->where('amount', request()->amount_equation, request()->amount);
                });
                $constraints++;
            }

            $emergency->latest();
            // return $emergency->dump();
            if ($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $emergency
                ->with([
                    'profit',
                    'registrar:id,name as name',
                ])->get() : $emergency
                ->with([
                    'profit',
                    'registrar:id,name_dr as name'
                ])->get();
        }

        return view('receptionist-module.emergency.filter');
    }

    public function print(Emergency $emergency)
    {

        $emergency->load(['profit']);

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
                <th>Emergency Bill Payment</th>
                <th>بل پرداخت ایمرجنسی</th>
            </tr>
        </table>';
        // $pdf->SetFont('times', '', 20);
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->Ln(3);

        $pdf->SetFontSize(12);
        $htmlRow1 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $emergency->reason . '</strong></th>
                <th> ' . __('global.reason') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow1 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $emergency->patient_name . '</strong></th>
                <th> ' . __('reception.pat_name') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $emergency->profit->totalAmount . ' ' . (app()->getLocale() == 'en' ? $emergency->profit->currency->label_en : $emergency->profit->currency->label_dr) . '</strong></th>
                <th> ' . __('reception.amountOfPayament') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'R');


        $htmlRow3 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $emergency->created_at->format('Y-m-d h:m A') . '</strong></th>
                <th> ' . __('profile.user_regdate') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');
        // output the HTML content

        $htmlRow4 = '<table>
            <tr>
                <th colspan="2"> <strong>'. (app()->getLocale() == 'en' ? $emergency->registrar->name : $emergency->registrar->name_dr) . '</strong></th>
                <th> ' . __('profile.user_registrant') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow4, true, false, true, false, 'R');
        // output the HTML content

        $pdf->Ln(20);
        $addr = '<table>
            <tr>
                <th> شماره های تماس: 0777757523 - 0785790890</th>
                <th colspan="2"> آدرس: کابل، چهارراهی سر سبزی، جوار هوتل شام پارس، شفاخانه آریا سیتی.</th>
            </tr>
        </table>';
        
        $pdf->SetFontSize(8);
        $pdf->writeHTML($addr, true, false, true, false, 'R');

        $pdf->Image('img/print-header.png', 0, 135, 210, 30, 'PNG', '', '', true);

        $pdf->SetFontSize(14);
        $pdf->Ln(40);
        
        
        $title = '<table>
            <tr>
                <th>Emergency Bill Payment</th>
                <th>بل پرداخت ایمرجنسی</th>
            </tr>
        </table>';
        // $pdf->SetFont('times', '', 20);
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->Ln(3);

        $pdf->SetFontSize(12);
        $htmlRow1 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $emergency->reason . '</strong></th>
                <th> ' . __('global.reason') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow1 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $emergency->patient_name . '</strong></th>
                <th> ' . __('reception.pat_name') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $emergency->profit->totalAmount . ' ' . (app()->getLocale() == 'en' ? $emergency->profit->currency->label_en : $emergency->profit->currency->label_dr) . '</strong></th>
                <th> ' . __('reception.amountOfPayament') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'R');


        $htmlRow3 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $emergency->created_at->format('Y-m-d h:m A') . '</strong></th>
                <th> ' . __('profile.user_regdate') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');
        // output the HTML content

        $htmlRow4 = '<table>
            <tr>
                <th colspan="2"> <strong>'. (app()->getLocale() == 'en' ? $emergency->registrar->name : $emergency->registrar->name_dr) . '</strong></th>
                <th> ' . __('profile.user_registrant') . ': </th>
            </tr>
        </table>';

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

        $pdf->Output('testPrint/example_001.pdf');
    }
}
