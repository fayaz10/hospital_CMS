<?php

namespace App\Http\Controllers\Pharmacist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacist\SurgeryPrescription;
use App\Models\Pharmacist\Medicine;
use App\iSys\Services\PrescriptionBill;
use TCPDF_FONTS;


class SurgeryPrescriptionController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('permission:phar_pres_show')->only(['index', 'show']);
        // $this->middleware('permission:phar_pres_create')->only(['create', 'store']);
        // $this->middleware('permission:phar_pres_edit')->only(['edit', 'update']);
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

        // $prescriptions = Prescription::with(['store', 'type', 'unit'])
        $prescriptions = SurgeryPrescription::with([
            'profit',
            'profit.currency',
            'patient',
            'approve',
        ])
            ->withCount(['medicines'])
            ->latest()
            ->paginate($limit);

        return view('pharmacist-module.surpres.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pharmacist-module.surpres.create');
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
            'patient_id' => 'required',
            'date' => 'required',
        ]);

        $patient = \App\Models\Receptionist\Patient::findOrFail(request()->patient_id);

        \DB::beginTransaction();

        $newPres = SurgeryPrescription::create([
            'patient_id' => request()->patient_id,
            'date' => request()->date,
            'registrar_id' => auth()->id(),
        ]);

        $totalAmount = 0;
        //the items
        foreach (request()->items as $item) {

            //get the medicine
            $medicine = Medicine::find($item['medicine_id']);

            //get the stock
            $stock = $medicine->store;

            try{
                // attach the medicine to list
                $newPres->medicines()->attach($medicine, [
                    // 'medicine_id' => $medicine->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $stock->unit_price,
                    'currency_id' => $stock->currency_id,
                    'registrar_id' => auth()->id(),
                ]);

                $totalAmount += $item['quantity'] * $stock->unit_price;

                $stock->quantity = $stock->quantity - $item['quantity'];

                $stock->save();

            } catch (\App\Exceptions\CustomException $e){
                throw new \App\Exceptions\CustomException(__('global.medOutOfStock', ['medicine' => $medicine->name]));
            } catch (\Exception $e){
                abort(500,"{$e->getMessage()}");
            }
        }

        $income = $newPres->profit()->save(new \App\Models\FinanceModule\Income([
            'payment_date' => date('Y-m-d'),
            'amount' => $totalAmount,
            'currency_id' => $patient->visits()->latest()->first()->profit->currency_id,
            'recipient' => app()->isLocale('en') ? auth()->user()->name : auth()->user()->name_dr,
            'tax' => config("iSys.tax.prescription", config("iSys.tax.default")),
            'registrar_id' => auth()->id(),
            'is_approved' => 0,
        ]));

        // Save the approvable
        // $newPres->approve()->save(new \App\Approvable([
        //     'record_no' => $newPres->patient->record_no .' ('. $newPres->patient->name .')',
        //     'type' => 'new',
        //     'amount' => $income->totalAmount,
        //     'currency_id' => $income->currency_id,
        //     'is_approved' => null,
        // ]));

        \DB::commit();

        return redirect(route('surpres.show', [$newPres->id]))
            ->with([
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
    public function show(SurgeryPrescription $surpre)
    {
        $surpre->load([
            'profit',
            'profit.currency',
            'patient',
            'registrar',
            'medicines',
            'medicines.unit',
        ]);
        
        return view('pharmacist-module.surpres.show', compact('surpre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SurgeryPrescription $surpre)
    {
        $surpre->load([
            'patient',
            'medicines',
            'medicines.unit',
        ]);

        return view('pharmacist-module.surpres.edit', compact('surpre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurgeryPrescription $surpre)
    {
        
        $this->validate(request(), [
            'patient_id' => 'required',
            'date' => 'required',
        ]);

        \DB::beginTransaction();

        $surpre->update([
            'patient_id' => request()->patient_id,
            'date' => request()->date,
        ]);

        // $saveState = ['old' => [
        //     'medicines' => [
        //             'collection' => $surpre->medicines()->get()->toArray(),
        //             'pivot' => 'medicine_stockout',
        //             'reversable' => [
        //                 'store' => 'quantity'
        //             ],
        //         ],
        //     'profit' => $surpre->profit->toArray(),
        //     ]
        // ];

        $totalAmount = 0;

        $oldMedi = request()->oldItems;

        foreach ($surpre->medicines as $medi) {

            //get the stock
            $stock = $medi->store;

            if($oldMedi && array_key_exists($medi->id, $oldMedi)){

                try{
                    $oldPrice = $medi->pivot->unit_price;
                    $oldQuantity = $medi->pivot->quantity;

                    $surpre->medicines()->updateExistingPivot($medi, [
                            'quantity' => $oldMedi[$medi->id]['quantity']
                        ]);

                    $totalAmount += $oldMedi[$medi->id]['quantity'] * $oldPrice;

                    $stock->quantity = $stock->quantity - ($oldMedi[$medi->id]['quantity'] - $oldQuantity);

                    $stock->save();

                } catch (\App\Exceptions\CustomException $e){
                    throw new \App\Exceptions\CustomException(__('global.medOutOfStock', ['medicine' => $medi->name]));
                    // throw new \App\Exceptions\CustomException("The {$medicine->name} is out of stock. please add this item to stock first.");
                } catch (\Exception $e){
                    abort(500,"{$e->getMessage()}");
                }

            } else{
                // recalculate the profit

                // restore stock values
                $stock->quantity = $stock->quantity + $medi->pivot->quantity;
                $stock->save();

                // sync the medicine
                $surpre->medicines()->detach($medi->id);
            }
        }

        if(request()->has('items'))
            //new medicines items
            foreach (request()->items as $item) {

                //get the medicine
                $medicine = Medicine::find($item['medicine_id']);

                //get the stock
                $stock = $medicine->store;

                try{
                    // attach the medicine to list
                    $surpre->medicines()->attach($medicine, [
                        // 'medicine_id' => $medicine->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $stock->unit_price,
                        'currency_id' => $stock->currency_id,
                        'registrar_id' => auth()->id(),
                    ]);

                    $totalAmount += $item['quantity'] * $stock->unit_price;

                    $stock->quantity = $stock->quantity - $item['quantity'];

                    $stock->save();

                } catch (\App\Exceptions\CustomException $e){
                    throw new \App\Exceptions\CustomException(__('global.medOutOfStock', ['medicine' => $medicine->name]));
                } catch (\Exception $e){
                    abort(500,"{$e->getMessage()}");
                }
            }

        $oldIncomeAmount = $surpre->profit->totalAmount;
        // dd([$oldIncomeAmount]);

        $profit = $surpre->profit;
        $profit->amount = $totalAmount;
        $profit->is_approved = 0;
        $profit->save();

        // $saveState += ['new' => [
        //     'medicines' => [
        //             'collection' => $surpre->medicines()->get()->toArray(),
        //             'pivot' => 'medicine_stockout',
        //             'reversable' => [
        //                 'store' => 'quantity'
        //             ],
        //         ],
        //     'profit' => $surpre->profit->toArray(),
        //     ]
        // ];
        
        // Save the approvable

        // $surpre->approve()->save(new \App\Approvable([
        //     'record_no' => $surpre->patient->record_no .' ('. $surpre->patient->name .')',
        //     'type' => $oldIncomeAmount >= $profit->totalAmount ? 'refund' : 'payment',
        //     'amount' => abs($oldIncomeAmount - $profit->totalAmount),
        //     'currency_id' => $profit->currency_id,
        //     'is_approved' => null,
        //     'state' => $saveState,
        // ]));

        // if($oldIncomeAmount != $profit->totalAmount)
        //     $surpre->update(['is_approved' => 0]);

        \DB::commit();

        return redirect(route('surpres.show', [$surpre->id]))
            ->with([
                'alert' => "performed",
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

    public function print(SurgeryPrescription $surpre)
    {
        $surpre->load([
            'profit',
            'profit.currency',
            'patient',
            'registrar',
            'medicines',
            'medicines.type',
            'medicines.unit',
        ]);

        $approve = $surpre->approve()->latest('approved_date')->first();

        $pdf = new PrescriptionBill();

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // Add a page
        $pdf->AddPage();
        // set some text for example
        $pdf->Ln(25);

        // set some language-dependent strings (optional)
        $pdf->setLanguageArray(['a_meta_language' => 'fa']);

        $fontname = TCPDF_FONTS::addTTFfont('fonts/Sahel.ttf', 'TrueTypeUnicode', '', 96);
        // $pdf->SetFont('dejavusans', '', 15);
        // use the font
        $pdf->SetFont($fontname, '', 14, '', false);

        $title = '<table>
            <tr>
                <th><strong>Prescription payment bill</strong></th>
                <th><strong>بل پرداخت نسخه</strong></th>
            </tr>
        </table>';
        // $pdf->SetFont('times', '', 20);
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->Ln(3);

        $pdf->SetFontSize(10);
        $htmlRow1 = '<table>
            <tr>
                <th> اسم داکتر: ' . optional($surpre->doctor)->name . '</th>
                <th>نمبر ریکورد: ' . $surpre->patient->record_no . '</th>
                <th> اسم مریض: ' . $surpre->patient->name . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
            <tr>
                <th> تخصص داکتر: ' . optional($surpre->doctor)->specialist . '</th>
                <th> تاریخ صدور: ' . ($approve->approved_date ?? $surpre->date) . '</th>
                <th> ثبت کننده: ' .$surpre->profit->registrar->name_dr. '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow2, true, false, true, false, 'R');

        $htmlRow3 = '<table>
                <tr>
                    <th><strong>فهرست دواهای تجویز شده</strong></th>
                </tr>
            </table>';

        $pdf->writeHTML($htmlRow3, true, false, true, false, 'R');


        $tableHead = '
            <table cellspacing="0" cellpadding="3" border="1">
                <tr>
                    <th>قیمت مجموع</th>
                    <th>مالیات</th>
                    <th>تعداد</th>
                    <th width="50">نوع دوا</th>
                    <th width="190">اسم دوا</th>
                    <th width="30">#</th>
                </tr>
        ';

        $tablebody ='';

        foreach($surpre->medicines as $key => $medicine){
            $tablebody .= '
                <tr>
                <td> ... </td>
                <td> ... </td>
                <td>(' .$medicine->pivot->quantity. ') '. (app()->isLocale('en') ? $medicine->unit->label_en : $medicine->unit->label_dr) .'</td>
                <td>' .(app()->isLocale('en') ? $medicine->type->label_en : $medicine->type->label_dr). '</td>
                <td>' .$medicine->name. '('.$medicine->milligram.')</td>
                <td>' .++$key. '</td>
                </tr>
            ';
        }

        $total = '('.$surpre->profit->totalAmount . ') ' . (app()->isLocale('en') ? $surpre->profit->currency->label_en : $surpre->profit->currency->label_dr) ;
        $tax = '('.$surpre->profit->taxes . ') ' . (app()->isLocale('en') ? $surpre->profit->currency->label_en : $surpre->profit->currency->label_dr) ;

        // $tablebody .= '
        //     <tr>
        //         <td>' . $total . '</td>
        //         <td>' .$tax. '</td>
        //         <td colspan="4"></td>
        //     </tr>
        // </table>';
        $tablebody .= '
            <tr>
                <td>' . $total . '</td>
                <td> ... </td>
                <td colspan="4"></td>
            </tr>
        </table>';

        $pdf->writeHTML($tableHead . $tablebody, true, false, true, false, 'R');

        $pdf->SetY(-30);

        $addr = '<table>
            <tr>
                <th> تماس ها : 077 775 7523 - 078 579 0890</th>
                <th> آدرس: کابل، چهارراهی سر سبزی، جوار هوتل شام پارس، شفاخانه آریا سیتی.</th>
            </tr>
        </table>';
        $pdf->SetFontSize(8);
        // $pdf->writeHTML($addr, true, false, true, false, 'R');

        // $pdf->Write(0, 10, 'تماس ها : 0777757523 - 0785790890', 0, false, 'C', 0, '', 0, false, 'T', 'M');


        $pdf->Output('testPrint/example_001.pdf');
    }

    public function filter()
    {
        if (request()->ajax()) {

            $prescription = SurgeryPrescription::query();
            $constraints = 0;

            if (request()->filled('registrar_id')) {
                $prescription->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('issue_date')) {
                $prescription->whereDate('date', request()->issue_date_equation, request()->issue_date);
                $constraints++;
            }
            if (request()->filled('from_date')) {
                $prescription->whereDate('created_at', request()->from_date_equation, request()->from_date);
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $prescription->whereDate('created_at', request()->till_date_equation, request()->till_date);
                $constraints++;
            }
            if (request()->filled('name')) {
                $name = request()->name;
                $prescription->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
                $constraints++;
            }
            if (request()->filled('record_no')) {
                $record_no = request()->record_no;
                $prescription->whereHas('patient', function ($query) use ($record_no) {
                    $query->where('record_no', $record_no);
                });
                $constraints++;
            }
            if (request()->filled('amount')) {
                $amount = request()->amount;
                $amount_equation = request()->amount_equation;
                $prescription->whereHas('profit', function ($query) use ($amount, $amount_equation) {
                    $query->where('amount', $amount_equation, $amount);
                });
                $constraints++;
            }

            $prescription->latest();
            // return $prescription->dump();
            if($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $prescription
                    ->with([
                        'patient:id,name,record_no',
                        'profit',
                        'registrar:id,name as name'
                        ])->get() :
                $prescription
                    ->with([
                        'patient:id,name,record_no',
                        'profit',
                        'registrar:id,name_dr as name'
                        ])->get() ;
        }

        return view('pharmacist-module.surpres.filter');
    }

    public function refund(SurgeryPrescription $surpre)
    {
        \DB::beginTransaction();

        $medicines = $surpre->medicines;

        $saveState = ['old' => [
            'medicines' => [
                    'collection' => $surpre->medicines()->get()->toArray(),
                    'pivot' => 'medicine_stockout',
                    'reversable' => [
                        'store' => 'quantity'
                    ],
                ],
            'profit' => $surpre->profit->toArray(),
            ]
        ];

        foreach($medicines as $med){

            //restore the medicine
            $store = $med->store;
            $store->quantity += $med->pivot->quantity;
            $store->save();

            //set zero the prescription
            // $surpre->medicines()->updateExistingPivot($med, ['quantity' => 0]);
            $surpre->medicines()->detach($med);
            
        }
        
        // Save the approvable

        // $surpre->approve()->save(new \App\Approvable([
        //     'record_no' => $surpre->patient->record_no .' ('. $surpre->patient->name .')',
        //     'type' => 'refund',
        //     'amount' => $surpre->profit->totalAmount,
        //     'currency_id' => $surpre->profit->currency_id,
        //     'is_approved' => null,
        //     'state' => $saveState,
        // ]));

        
        // $surpre->profit()->update(['amount' => 0, 'is_approved' => 0]);
        // $surpre->update(['status' => 0]);

        \DB::commit();

        return back()->with([
            'alert' => "performed",
            'class' => 'alert-info'
        ]);
    }

    public function sent2Approve(SurgeryPrescription $surpre)
    {
        // Save the approvable
        $surpre->approve()->save(new \App\Approvable([
            'record_no' => optional($surpre->patient)->record_no .' ('. optional($surpre->patient)->name .')',
            'type' => 'new',
            'amount' => $surpre->profit->totalAmount,
            'currency_id' => $surpre->profit->currency_id,
            'is_approved' => null,
        ]));

        return back()->with([
            'alert' => "performed",
            'class' => 'alert-info'
        ]);
    }
}
