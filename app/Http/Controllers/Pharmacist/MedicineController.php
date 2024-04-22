<?php

namespace App\Http\Controllers\Pharmacist;

use App\Models\Pharmacist\Medicine;
use App\Http\Controllers\Controller;

class MedicineController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:phar_med_show')->only(['index', 'show']);
        $this->middleware('permission:phar_med_create')->only(['create', 'store']);
        $this->middleware('permission:phar_med_edit')->only(['edit', 'update']);
        $this->middleware('permission:phar_med_assign')->only(['assignMultiple', 'editMultiple']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $medicines = Medicine::with(['store', 'type', 'unit'])
            ->orderBy('expire_date', 'desc')
            ->paginate($limit);

        // dd($medicines);
        return view('pharmacist-module.medicine.index', compact('medicines'));
    }

    public function show(Medicine $medicine)
    {
        if (request()->ajax()) {
            $medicine->load('type', 'unit', 'store', 'store.currency');
            return $medicine->toJson();
        }
        
        $medicine->load('type', 'unit', 'store', 'store.currency');

        return view('pharmacist-module.medicine.show', compact('medicine'));
    }

    public function create()
    {
        if(request()->exists('multiple'))
            return $this->createMultiple();

        return view('pharmacist-module.medicine.create');
    }

    public function createMultiple()
    {
        return view('pharmacist-module.medicine.create-multiple');
    }
    public function storeMultiple()
    {
        //the items
        foreach (request()->items as $item) {

            $newMedicine = Medicine::create([
                'name' => $item['name'],
                'milligram' => $item['milligram'],
                'company' => $item['company'],
                'type_id' => $item['type_id'],
                'unit_id' => $item['unit_id'],
            ]);
    
            $newMedicine->store()->save(new \App\Models\Stock\Stock([
                'quantity' => array_key_exists('quantity', $item) ? $item['quantity'] : 0,
                'unit_price' => array_key_exists('unit_price', $item) ? $item['unit_price'] : 0,
                'currency_id' => \App\Models\FinanceModule\Currency::first() ? \App\Models\FinanceModule\Currency::first()->id : 0,
            ]));
        }
        
        return redirect(route('medicine.index'))
            ->with([
                'alert' => "performed",
                'class' => 'alert-info'
            ]);
    }

    public function store()
    {
        if(request()->exists('multiple'))
            return $this->storeMultiple();

        $this->validate(request(), [
            'name' => 'required|min:2',
            'milligram' => 'required',
            'company' => 'required|min:2',
            'type_id' => 'required|numeric',
            'unit_id' => 'required',
        ]);

        \DB::beginTransaction();

        $newMedicine = Medicine::create([
            'name' => request()->name,
            'milligram' => request()->milligram,
            'company' => request()->company,
            'type_id' => request()->type_id,
            'unit_id' => request()->unit_id,
            'expire_date' => request()->expire_date,
        ]);

        $newMedicine->store()->save(new \App\Models\Stock\Stock([
            'quantity' => request()->has('quantity') ? request()->quantity : 0,
            'unit_price' => request()->has('unit_price') ? request()->unit_price : 0,
            'currency_id' => request()->has('currency_id') ? request()->currency_id : \App\Models\FinanceModule\Currency::first()->id,
        ]));

        \DB::commit();

        return redirect(route('medicine.show', [$newMedicine->id]))->with([
            'alert' => "created",
            'class' => 'alert-info'
        ]);
    }

    public function edit(Medicine $medicine)
    {
        return view('pharmacist-module.medicine.edit', compact('medicine'));
    }
    public function update(Medicine $medicine)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'milligram' => 'required|min:3',
            'company' => 'required|min:3',
            'type_id' => 'required|numeric',
            'unit_id' => 'required',
        ]);

        $medicine->update(request()->except(['_token', '_method']));

        return redirect(route('medicine.show', [$medicine->id]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand'
            ]);
    }

    public function ajaxFilter()
    {
        $medicines = Medicine::with('type:id,label_en,label_dr')
            // ->select('id', 'name', 'milligram', 'company')
            ->where('name', 'like', '%' . request()->name . '%')
            ->get()
            ->toJson();
        return $medicines;
    }

    public function search()
    {
        if (request()->ajax())
            return Medicine::search(request()->term)
                ->get();
    }

    public function editMultiple()
    {
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;


        if (request()->filled('term'))
            $medicines = Medicine::with(['store', 'type', 'unit'])
                    ->where('name', 'like', '%' . request()->term . '%')
                    ->paginate($limit);
        else 
            $medicines = Medicine::with(['store', 'type', 'unit'])
                ->latest()
                ->paginate($limit);

        // dd($medicines);
        return view('pharmacist-module.medicine.edit-multiple', compact('medicines'));
    }

    public function assignMultiple()
    {
        $this->validate(request(), [
            'medicine.*.quantity' => 'nullable|min:0',
            'medicine.*.unit_price' => 'nullable|min:0',
        ]);
        
        //the items
        foreach (request()->medicine as $id => $item) {

            $medicine = Medicine::find($id);
    
            if(array_key_exists('expire_date', $item))
                $medicine->update(['expire_date' => $item['expire_date']]);

            $medicine->store()->update([
                'quantity' => array_key_exists('quantity', $item) ? $item['quantity'] : 0,
                'unit_price' => array_key_exists('unit_price', $item) ? $item['unit_price'] : 0,
            ]);
        }

        return back()->with([
            'alert' => "performed",
            'class' => 'alert-info'
        ]);
    }
    
    public function filter()
    {
        if (request()->ajax()) {

            $medicines = Medicine::query();
            $constraints = 0;

            if (request()->filled('type_id')) {
                $medicines->where('type_id', request()->type_id);
                $constraints++;
            }
            if (request()->filled('unit_id')) {
                $medicines->where('unit_id', request()->unit_id);
                $constraints++;
            }
            if (request()->filled('mg')) {
                $medicines->where('milligram',request()->mg_equation ,request()->mg);
                $constraints++;
            }
            
            if (request()->filled('name')) {
                $medicines->where('name', 'like', '%' . request()->name . '%');
                $constraints++;
            }
            if (request()->filled('company')) {
                $medicines->where('company', 'like', '%' . request()->company . '%');
                $constraints++;
            }
            if (request()->filled('quantity')) {
                $quantity = request()->quantity;
                $quantity_equation = request()->quantity_equation;
                $medicines->whereHas('store', function ($query) use ($quantity, $quantity_equation) {
                    $query->where('quantity', $quantity_equation, $quantity);
                });
                $constraints++;
            }
            if (request()->filled('unit_price')) {
                $unit_price = request()->unit_price;
                $unit_price_equation = request()->unit_price_equation;
                $medicines->whereHas('store', function ($query) use ($unit_price, $unit_price_equation) {
                    $query->where('unit_price', $unit_price_equation, $unit_price);
                });
                $constraints++;
            }
            if (request()->filled('last_date')) {
                $last_date = request()->last_date;
                $last_date_equation = request()->last_date_equation;
                $medicines->whereHas('purchased', function ($query) use ($last_date, $last_date_equation) {
                    $query->where('purchase_date', $last_date_equation, $last_date);
                });
                $constraints++;
            }
            
            $medicines->latest();
            
            if($constraints <= 0)
                return [];
            // return $medicines->dump();
            return
                app()->isLocale('en') ?
                $medicines
                    ->with([
                        'store',
                        'purchased'=> function($query){
                            $query->orderBy('id', 'DESC')->first();
                        },
                        'type:id,name,label_en as label',
                        'unit:id,name,label_en as label'
                        ])->get() :
                $medicines
                    ->with([
                        'store',
                        'purchased'=> function($query){
                            $query->orderBy('id', 'DESC')->first();
                        },
                        'type:id,name,label_dr as label',
                        'unit:id,name,label_dr as label'
                        ])->get() ;
        }

        return view('pharmacist-module.medicine.filter');
    }
}
