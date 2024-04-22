<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\iSys\Services\PrescriptionBill;
use App\Models\Pharmacist\Prescription;
use App\Models\Pharmacist\SurgeryPrescription;
use App\Models\Pharmacist\Medicine;
use TCPDF_FONTS;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PrescriptionController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:phar_pres_show')->only(['index', 'show']);
        $this->middleware('permission:phar_pres_create')->only(['create', 'store']);
        $this->middleware('permission:phar_pres_edit')->only(['edit', 'update']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        // get the selected tav
        $tab = request()->has('tab') ? request()->tab : 'all-pres';

        $aPage = request()->filled('page') && request()->page > 1 ? request()->page - 1 : 0;
        
        $searches = null;
        // Searched Item
        if(request()->filled('term')){

            $searchSurpresColl = SurgeryPrescription::with([
                    'profit',
                    'profit.currency',
                    'patient',
                    'approve',
                ])
                ->where('patient_id', request()->term)
                ->withCount(['medicines'])
                ->latest()
                ->skip($aPage * 10)
                ->take(10)
                ->get();
                
            
            $searchReminderCounter = $searchSurpresColl->count() >= 10 ? 0 : (10 - $searchSurpresColl->count());

            $searchPresColl = Prescription::with([
                    'doctor',
                    'profit',
                    'profit.currency',
                    'patient',
                    'approve',
                ])
                ->withCount(['medicines'])
                ->where('patient_id', request()->term)
                ->latest()
                ->skip($aPage * 40)
                ->take((40 + $searchReminderCounter))
                ->get();

            $searches = $searchSurpresColl->merge($searchPresColl)
                            ->sortByDesc('created_at');
            
            $searches = $this->paginate($searches, ($searchSurpresColl->count() + $searchPresColl->count()), 50, null, ['pageName' => 'searchPage']);
            // dd($prescriptions);
            $searches->setPath(route('prescription.index'));
        }
        
        $surpresColl = SurgeryPrescription::with([
                'profit',
                'profit.currency',
                'patient',
                'approve',
            ])
            ->withCount(['medicines'])
            ->latest()
            ->skip($aPage * 10)
            ->take(10)
            ->get();
            
        $reminderCounter = $surpresColl->count() >= 10 ? 0 : (10 - $surpresColl->count());

        $presColl = Prescription::with([
                'doctor',
                'profit',
                'profit.currency',
                'patient',
                'approve',
            ])
            ->withCount(['medicines'])
            ->latest()
            ->skip($aPage * 40)
            ->take((40 + $reminderCounter))
            ->get();

        $collOfMerged = $presColl->merge($surpresColl)
                            ->sortByDesc('created_at');

        $prescriptions = $this->paginate($collOfMerged, (SurgeryPrescription::count() + Prescription::count()), 50);
        // dd($prescriptions);
        $prescriptions->setPath(route('prescription.index'));
                            
        // $prescriptions = Prescription::with(['store', 'type', 'unit'])
        $pendingPres = Prescription::with([
                'doctor',
                'profit',
                'profit.currency',
                'patient',
                'approve',
            ])
            ->whereHas('approve', function ($query) {
                $query->orderBy('created_at', 'desc');
                $query->whereNull('is_approved');
                $query->take(1);
            })
            ->withCount(['medicines'])
            ->latest()
            ->paginate($limit, ['*'], 'pendingPage');
            
        // Surgery Prescription
        $surpreses = SurgeryPrescription::with([
            'profit',
            'profit.currency',
            'patient',
            'approve',
        ])
            ->withCount(['medicines'])
            ->latest()
            ->paginate($limit, ['*'], 'surpresPage');

        $paidPres = Prescription::with([
                'doctor',
                'profit',
                'profit.currency',
                'patient',
                'approve',
            ])
            ->where('is_approved', 1)
            ->withCount(['medicines'])
            ->latest()
            ->paginate($limit, ['*'], 'paidPage');

        $rejectedPres = Prescription::with([
                'doctor',
                'profit',
                'profit.currency',
                'patient',
                'approve',
            ])
            ->whereHas('approve', function ($query) {
                $query->orderBy('created_at', 'desc');
                $query->where('is_approved', 0);
                $query->take(1);
            })
            ->withCount(['medicines'])
            ->latest()
            ->paginate($limit, ['*'], 'rejectedPage');

        return view('pharmacist-module.prescription.index', 
            compact('prescriptions', 'tab', 'searches', 'surpreses', 'pendingPres', 'paidPres', 'rejectedPres'));
    }

    public function show(Prescription $prescription)
    {
        
        $prescription->load([
            'doctor',
            'profit',
            'profit.currency',
            'patient',
            'registrar',
            'medicines',
            'medicines.unit',
        ]);
        
        return view('pharmacist-module.prescription.show', compact('prescription'));
    }

    public function create()
    {
        return view('pharmacist-module.prescription.create');
    }

    public function store()
    {

        $this->validate(request(), [
            'patient_id' => 'required',
            'doctor_id' => 'required_without:same_doctor',
            'date' => 'required',
        ]);

        // redirect if patient will payment later
        // if(request()->type == 'later') return redirect()->route('surpres.store', request()->all());
        // dd(request());
        // if(request()->type == 'later') {
        //     $redirection = new \Illuminate\Http\Request();
        //     $redirection->setMethod('POST');
        //     $redirection->request->add(request()->all());
        //     dd($redirection);
        // }
        // if(request()->type == 'later') 
        //     return redirect()->action(
        //         'Pharmacist\SurgeryPrescriptionController@store', request()
        //     );

        $patient = \App\Models\Receptionist\Patient::findOrFail(request()->patient_id);

        \DB::beginTransaction();

        $newPres = Prescription::create([
            'patient_id' => request()->patient_id,
            'doctor_id' => request()->has('doctor_id')
                ? request()->doctor_id
                : $patient->visits()->latest()->first()->doctor_id,

            'date' => request()->date,
            'diagnosis' => request()->diagnosis,
            'registrar_id' => auth()->id(),
            'is_approved' => false,
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
        $newPres->approve()->save(new \App\Approvable([
            'record_no' => $newPres->patient->record_no .' ('. $newPres->patient->name .')',
            'type' => 'new',
            'amount' => $newPres->profit->totalAmount,
            'currency_id' => $income->currency_id,
            'is_approved' => null,
        ]));

        \DB::commit();

        return redirect(route('prescription.show', [$newPres->id]))
            ->with([
                'alert' => "created",
                'class' => 'alert-info'
            ]);
    }

    public function edit(Prescription $prescription)
    {
        $prescription->load([
            'doctor',
            'patient',
            'medicines',
            'medicines.unit',
        ]);

        return view('pharmacist-module.prescription.edit', compact('prescription'));
    }

    public function update(Prescription $prescription)
    {

        $this->validate(request(), [
            'patient_id' => 'required',
            'doctor_id' => 'required_without:same_doctor',
            'date' => 'required',
        ]);

        \DB::beginTransaction();

        $prescription->update([
            'patient_id' => request()->patient_id,
            'doctor_id' => request()->doctor_id ,
            'date' => request()->date,
            'diagnosis' => request()->diagnosis,
        ]);

        $saveState = ['old' => [
            'medicines' => [
                    'collection' => $prescription->medicines()->get()->toArray(),
                    'pivot' => 'medicine_stockout',
                    'reversable' => [
                        'store' => 'quantity'
                    ],
                ],
            'profit' => $prescription->profit->toArray(),
            ]
        ];

        $totalAmount = 0;

        $oldMedi = request()->oldItems;

        foreach ($prescription->medicines as $medi) {

            //get the stock
            $stock = $medi->store;

            if($oldMedi && array_key_exists($medi->id, $oldMedi)){

                try{
                    $oldPrice = $medi->pivot->unit_price;
                    $oldQuantity = $medi->pivot->quantity;

                    $prescription->medicines()->updateExistingPivot($medi, [
                            'quantity' => $oldMedi[$medi->id]['quantity']
                        ]);

                    $totalAmount += $oldMedi[$medi->id]['quantity'] * $oldPrice;

                    $stock->quantity = $stock->quantity - ($oldMedi[$medi->id]['quantity'] - $oldQuantity);

                    $stock->save();

                } catch (\App\Exceptions\CustomException $e){
                    throw new \App\Exceptions\CustomException(__('global.medOutOfStock', ['medicine' => $medicine->name]));
                    // throw new \App\Exceptions\CustomException("The {$medicine->name} is out of stock. please add this item to stock first.");
                } catch (\Exception $e){
                    abort(500,"{$e->getMessage()}");
                }

            } else{
                // recalculate the profit
                // $totalAmount -= $medi->pivot->quantity * $medi->pivot->unit_price;

                // restore stock values
                $stock->quantity = $stock->quantity + $medi->pivot->quantity;
                $stock->save();

                // sync the medicine
                $prescription->medicines()->detach($medi->id);
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
                    $prescription->medicines()->attach($medicine, [
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

        $oldIncomeAmount = $prescription->profit->totalAmount;
        // dd([$oldIncomeAmount]);

        $profit = $prescription->profit;
        $profit->amount = $totalAmount;
        $profit->is_approved = 0;
        $profit->save();

        $saveState += ['new' => [
            'medicines' => [
                    'collection' => $prescription->medicines()->get()->toArray(),
                    'pivot' => 'medicine_stockout',
                    'reversable' => [
                        'store' => 'quantity'
                    ],
                ],
            'profit' => $prescription->profit->toArray(),
            ]
        ];
        
        // Save the approvable

        $prescription->approve()->save(new \App\Approvable([
            'record_no' => $prescription->patient->record_no .' ('. $prescription->patient->name .')',
            'type' => $oldIncomeAmount >= $profit->totalAmount ? 'refund' : 'payment',
            'amount' => abs($oldIncomeAmount - $profit->totalAmount),
            'currency_id' => $profit->currency_id,
            'is_approved' => null,
            'state' => $saveState,
        ]));

        if($oldIncomeAmount != $profit->totalAmount)
            $prescription->update(['is_approved' => 0]);

        \DB::commit();

        return redirect(route('prescription.show', [$prescription->id]))
            ->with([
                'alert' => "performed",
                'class' => 'alert-info'
            ]);
    }

    public function refund(Prescription $prescription)
    {
        \DB::beginTransaction();

        $medicines = $prescription->medicines;

        $saveState = ['old' => [
            'medicines' => [
                    'collection' => $prescription->medicines()->get()->toArray(),
                    'pivot' => 'medicine_stockout',
                    'reversable' => [
                        'store' => 'quantity'
                    ],
                ],
            'profit' => $prescription->profit->toArray(),
            ]
        ];

        foreach($medicines as $med){

            //restore the medicine
            $store = $med->store;
            $store->quantity += $med->pivot->quantity;
            $store->save();

            //set zero the prescription
            // $prescription->medicines()->updateExistingPivot($med, ['quantity' => 0]);
            $prescription->medicines()->detach($med);
            
        }
        
        // Save the approvable

        $prescription->approve()->save(new \App\Approvable([
            'record_no' => $prescription->patient->record_no .' ('. $prescription->patient->name .')',
            'type' => 'refund',
            'amount' => $prescription->profit->totalAmount,
            'currency_id' => $prescription->profit->currency_id,
            'is_approved' => null,
            'state' => $saveState,
        ]));

        
        $prescription->profit()->update(['amount' => 0, 'is_approved' => 0]);
        $prescription->update(['status' => 0]);

        \DB::commit();

        return back()->with([
            'alert' => "performed",
            'class' => 'alert-info'
        ]);
    }

    public function print(Prescription $prescription)
    {
        $prescription->load([
            'doctor',
            'profit',
            'profit.currency',
            'patient',
            'registrar',
            'medicines',
            'medicines.type',
            'medicines.unit',
        ]);

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
                <th> اسم داکتر: ' . $prescription->doctor->name . '</th>
                <th>نمبر ریکورد: ' . $prescription->patient->record_no . '</th>
                <th> اسم مریض: ' . $prescription->patient->name . '</th>
            </tr>
        </table>';

        $pdf->writeHTML($htmlRow1, true, false, true, false, 'R');

        $htmlRow2 = '<table>
            <tr>
                <th> تخصص داکتر: ' . $prescription->doctor->specialist . '</th>
                <th> تاریخ صدور: ' . $prescription->date . '</th>
                <th> ثبت کننده: ' .$prescription->profit->registrar->name_dr. '</th>
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

        foreach($prescription->medicines as $key => $medicine){
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

        $total = '('.$prescription->profit->totalAmount . ') ' . (app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr) ;
        $tax = '('.$prescription->profit->taxes . ') ' . (app()->isLocale('en') ? $prescription->profit->currency->label_en : $prescription->profit->currency->label_dr) ;

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

            $prescription = Prescription::query();
            $constraints = 0;

            if (request()->filled('registrar_id')) {
                $prescription->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('doctor_id')) {
                $prescription->where('doctor_id', request()->doctor_id);
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
                        'doctor:id,first_name,last_name',
                        'patient:id,name,record_no',
                        'profit',
                        'registrar:id,name as name',
                        'profit.approvedBy:id,name as name',
                        ])->get() :
                $prescription
                    ->with([
                        'doctor:id,first_name,last_name',
                        'patient:id,name,record_no',
                        'profit',
                        'registrar:id,name_dr as name',
                        'profit.approvedBy:id,name_dr as name',
                        ])->get() ;
        }

        return view('pharmacist-module.prescription.filter');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $total, $perPage = 50, $page = null, $options = [])
    {
        // dd(func_get_args());
        $total = $total ?: $items->count();
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items, $total, $perPage, $page, $options);
    }
}
