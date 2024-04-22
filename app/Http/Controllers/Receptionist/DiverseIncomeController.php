<?php

namespace App\Http\Controllers\Receptionist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FinanceModule\DiverseIncome;
use App\Models\FinanceModule\Income;
use App\iSys\Services\VisitBill;
use TCPDF;
use TCPDF_FONTS;

class DiverseIncomeController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:fin_din_show')->only(['index', 'show']);
        $this->middleware('permission:fin_din_create')->only(['create', 'store']);
        $this->middleware('permission:fin_din_edit')->only(['edit', 'update']);
        $this->middleware('permission:fin_din_delete')->only(['destroy']);
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

        $incomes = DiverseIncome::with(['profit', 'profit.currency', 'category'])
            ->latest()
            ->paginate($limit);

        return view('receptionist-module.din.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('receptionist-module.din.create');
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
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|gt:1',
            'currency_id' => 'required|numeric',
            'type' => 'required',
            'recipient' => 'required',
            'category_id' => 'required',
            'subject' => 'required',
            'discount' => 'nullable|numeric|between:0,100|required_with:member_id',

        ]);

        \DB::beginTransaction();

        $DIncome = DiverseIncome::create([
            'type' => request()->type,
            'category_id' => $this->categrorable(request()->category_id),
            'subject' => request()->subject,
            'registrar_id' => auth()->id(),
            'description' => request()->description,
            'patient_id' => request()->patient_id,
            'doctor_id' => request()->doctor_id,
            'dossier_no' => request()->dossier_no,
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
            'tax' => config("iSys.tax.DiverseIncome", config("iSys.tax.default")),
            'registrar_id' => auth()->id(),
            'approved_user' => auth()->id(),
            'is_approved' => 1,
        ]);

        // save the all incomes
        $DIncome->profit()->save($newIncome);

        \DB::commit();

        return redirect(route('din.index'))->with([
            'alert' => "performed",
            'class' => 'alert-info'
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DiverseIncome $din)
    {
        $din->load(['profit', 'profit.currency', 'category']);
        return view('receptionist-module.din.show', compact('din'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DiverseIncome $din)
    {
        $din->load(['profit', 'profit.currency', 'category']);
        return view('receptionist-module.din.edit', compact('din')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiverseIncome $din)
    {
        $this->validate(request(), [
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|gt:1',
            'currency_id' => 'required|numeric',
            'type' => 'required',
            'recipient' => 'required',
            'category_id' => 'required',
            'subject' => 'required',
        ]);

        \DB::beginTransaction();

        $din->update([
            'type' => request()->type,
            'category_id' => $this->categrorable(request()->category_id),
            'subject' => request()->subject,
            'description' => request()->description,
            'patient_id' => request()->patient_id,
            'dossier_no' => request()->dossier_no,
            'doctor_id' => request()->doctor_id,
        ]);

        $din->profit()->update([
            'payment_date' => request()->payment_date,
            'amount' => request()->amount,
            'currency_id' => request()->currency_id,
            'recipient' => request()->recipient,
        ]);

        \DB::commit();

        return redirect(route('din.index'))->with([
            'alert' => "edited",
            'class' => 'alert-brand'
        ]);
    }
    
    public function search()
    {

        if (request()->ajax())
            return DiverseIncome::search(request()->term)
                ->get();
    }
    
    public function filter()
    {
        if (request()->ajax()) {

            $incomes = DiverseIncome::query();
            $constraints = 0;

            if (request()->filled('registrar_id')) {
                $incomes->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('category')) {
                $incomes->where('category_id', request()->category);
                $constraints++;
            }
            if (request()->filled('dossier_no')) {
                $incomes->where('dossier_no', request()->dossier_no_equation, request()->dossier_no);
                $constraints++;
            }
            if (request()->filled('payment_date')) {
                $incomes->whereDate('payment_date', request()->payment_date_equation, request()->payment_date);
                $constraints++;
            }

            if (request()->filled('from_date')) {
                $incomes->whereDate('created_at', request()->from_date_equation, request()->from_date);
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $incomes->whereDate('created_at', request()->till_date_equation, request()->till_date);
                $constraints++;
            }
            if (request()->filled('subject')) {
                $incomes->where('subject', 'like', '%' . request()->subject . '%');
                $constraints++;
            }
            if (request()->filled('type')) {
                $incomes->where('type', 'like', '%' . request()->type . '%');
                $constraints++;
            }
            if (request()->filled('recipient')) {
                $recipient = request()->recipient;
                $incomes->whereHas('profit', function ($query) use ($recipient) {
                    $query->where('recipient', 'like', '%' . $recipient . '%');
                });
                $constraints++;
            }
            if (request()->filled('amount')) {
                $amount = request()->amount;
                $incomes->whereHas('profit', function ($query) use ($amount) {
                    $query->where('amount', request()->amount_equation, request()->amount);
                });
                $constraints++;
            }
            if (request()->filled('patient_id')) {
                $patient = request()->patient_id;
                $incomes->whereHas('patient', function ($query) use ($patient) {
                    $query->where('record_no', request()->patient_id_equation, $patient);
                });
                $constraints++;
            }

            $incomes->latest();
            // return $incomes->dump();
            if ($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $incomes
                ->with([
                    'category:id,label_en as label',
                    'profit',
                    'registrar:id,name as name',
                ])->get() : $incomes
                ->with([
                    'category:id,label_dr as label',
                    'profit',
                    'registrar:id,name_dr as name'
                ])->get();
        }

        return view('receptionist-module.din.filter');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiverseIncome $din)
    {
        \DB::beginTransaction();

        $din->profit->delete();
        $din->delete();

        \DB::commit();

        return redirect(route('din.index'))->with([
            'alert' => "deleted",
            'class' => 'alert-danger'
        ]);
    }

    public function categrorable($category)
    {
        if (is_numeric($category)) return $category;

        $id = \DB::table('diverse_category')->insertGetId([
                'name' => $category,
                'label_dr' => $category,
                'label_en' => $category,
            ]);

        return $id;
    }

    public function print(DiverseIncome $din)
    {

        $din->load(['profit', 'patient']);

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
                <th>Payment bill</th>
                <th>بل پرداخت</th>
            </tr>
        </table>';
        // $pdf->SetFont('times', '', 20);
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->Ln(3);

        $pdf->SetFontSize(12);
        if ($din->patient){
            $htmlRow0 = '<table>
                <tr>
                    <th colspan="2"> <strong>'. optional($din->patient)->name . ' (' .optional($din->patient)->record_no. ')</strong></th>
                    <th> ' . __('reception.pat_name') . ': </th>
                </tr>
            </table>';
    
            $pdf->writeHTML($htmlRow0, true, false, true, false, 'R');
        }

        $htmlRow1 = '<table>
            <tr>
                <th colspan="2"> <strong>'. (app()->getLocale() == 'en' ? $din->category->label_en : $din->category->label_dr) . '/ '. $din->subject . '</strong></th>
                <th> ' . __('global.reason') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $din->profit->totalAmount . ' ' . (app()->getLocale() == 'en' ? $din->profit->currency->label_en : $din->profit->currency->label_dr) . '</strong></th>
                <th> ' . __('reception.amountOfPayament') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'R');


        $htmlRow3 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $din->created_at->format('Y-m-d h:m A') . '</strong></th>
                <th> ' . __('profile.user_regdate') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');
        // output the HTML content

        $htmlRow4 = '<table>
            <tr>
                <th colspan="2"> <strong>'. (app()->getLocale() == 'en' ? $din->registrar->name : $din->registrar->name_dr) . '</strong></th>
                <th> ' . __('profile.user_registrant') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow4, true, false, true, false, 'R');
        // output the HTML content

        $pdf->Ln(27);
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
        $pdf->Ln(42);
        $title = '<table>
            <tr>
                <th>Payment bill</th>
                <th>بل پرداخت</th>
            </tr>
        </table>';
        // $pdf->SetFont('times', '', 20);
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->Ln(3);

        $pdf->SetFontSize(12);
        $htmlRow1 = '<table>
            <tr>
                <th colspan="2"> <strong>'. (app()->getLocale() == 'en' ? $din->category->label_en : $din->category->label_dr) . '/ '. $din->subject . '</strong></th>
                <th> ' . __('global.reason') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $din->profit->totalAmount . ' ' . (app()->getLocale() == 'en' ? $din->profit->currency->label_en : $din->profit->currency->label_dr) . '</strong></th>
                <th> ' . __('reception.amountOfPayament') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'R');


        $htmlRow3 = '<table>
            <tr>
                <th colspan="2"> <strong>'. $din->created_at->format('Y-m-d h:m A') . '</strong></th>
                <th> ' . __('profile.user_regdate') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');
        // output the HTML content

        $htmlRow4 = '<table>
            <tr>
                <th colspan="2"> <strong>'. (app()->getLocale() == 'en' ? $din->registrar->name : $din->registrar->name_dr) . '</strong></th>
                <th> ' . __('profile.user_registrant') . ': </th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow4, true, false, true, false, 'R');
        // output the HTML content

        $pdf->Ln(36);
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
