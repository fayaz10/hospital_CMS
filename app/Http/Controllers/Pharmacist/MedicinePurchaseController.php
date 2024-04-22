<?php

namespace App\Http\Controllers\Pharmacist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacist\MedicinePuchase;
use App\Models\Pharmacist\Medicine;

class MedicinePurchaseController extends Controller
{
    
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:phar_pur_show')->only(['index', 'show']);
        $this->middleware('permission:phar_pur_create')->only(['create', 'store']);
        $this->middleware('permission:phar_pur_edit')->only(['edit', 'update']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $purchases = MedicinePuchase::with(['medicines', 'spend'])
            ->latest()
            ->paginate($limit);

        return view('pharmacist-module.purchase.index', compact('purchases'));
    }

    public function show(MedicinePuchase $medicine_purchase)
    {

        $medicinePurchase = $medicine_purchase;
        unset($medicine_purchase);

        $medicinePurchase->load(['medicines', 'medicines.unit', 'medicines.type', 'medicines.store', 'spend', 'spend.currency', 'spend.registrar']);

        return view('pharmacist-module.purchase.show', compact('medicinePurchase'));
    }
    public function edit(MedicinePuchase $medicine_purchase)
    {

        $medicinePurchase = $medicine_purchase;
        unset($medicine_purchase);

        return view('pharmacist-module.purchase.edit', compact('medicinePurchase'));
    }

    public function create()
    {
        return view('pharmacist-module.purchase.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'purchase_date' => 'required',
            'remitter' => 'required',
            'currency_id' => 'required',
        ]);

        $purchasedMedicines = MedicinePuchase::create([
            'suppliers' => request()->suppliers,
            'purchase_date' => request()->purchase_date,
            'registrar_id' => auth()->id(),
        ]);

        //the items
        foreach (request()->items as $item) {

            //get the medicine
            $medicine = Medicine::find($item['medicine_id']);

            //get the stock
            $stock = $medicine->store;

            //get the benefit percentage
            $benefit = config("iSys.benefits.medicinePurchase", config("iSys.benefits.default"));

            // attach the medicine to list
            $purchasedItem = $purchasedMedicines->medicines()->attach($medicine, [
                'currency_id' => request()->currency_id,
                'total_price' => $item['total_price'],
                'quantity' => $item['quantity'],
                'benefits' => $benefit,
            ]);

            $stock->quantity = $stock->quantity + $item['quantity'];
            // $stock->unit_price = ($item['total_price'] + \App\iSys\Services\IncomeFormatter::toAmount($item['total_price'], $benefit)) / $item['quantity'];
            $stock->unit_price = \App\iSys\Services\ExpenseHelper::unitPriceWithBenefits($item['total_price'], $item['quantity']);

            $stock->save();
        }

        $purchasedMedicines->spend()->save(new \App\Models\FinanceModule\Expense([
            'payment_date' => request()->purchase_date,
            'amount' => $purchasedMedicines->medicines->sum('pivot.total_price'),
            'currency_id' => request()->currency_id,
            'remitter' => request()->remitter,
            'registrar_id' => auth()->id(),
        ]));

        return redirect(route('medicine-purchase.show', [$purchasedMedicines->id]))
            ->with([
                'alert' => "created",
                'class' => 'alert-info'
            ]);
    }

    public function update(MedicinePuchase $medicine_purchase)
    {

        $this->validate(request(), [
            'purchase_date' => 'required',
        ]);

        $medicine_purchase->update([
            'purchase_date' => request()->purchase_date,
            'suppliers' => request()->suppliers,
        ]);

        return redirect(route('medicine-purchase.show', [$medicine_purchase->id]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand'
            ]);
    }

    
    public function filter()
    {
        if (request()->ajax()) {

            $purchase = MedicinePuchase::query();
            $constraints = 0;

            if (request()->filled('registrar_id')) {
                $purchase->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('purchase_date')) {
                $purchase->whereDate('purchase_date', request()->purchase_date_equation, request()->purchase_date);
                $constraints++;
            }
            
            if (request()->filled('from_date')) {
                $purchase->whereDate('created_at', request()->from_date_equation, request()->from_date);
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $purchase->whereDate('created_at', request()->till_date_equation, request()->till_date);
                $constraints++;
            }
            if (request()->filled('suppliers')) {
                $purchase->where('suppliers', 'like', '%' . request()->suppliers . '%');
                $constraints++;
            }
            if (request()->filled('amount')) {
                $amount = request()->amount;
                $amount_equation = request()->amount_equation;
                $purchase->whereHas('spend', function ($query) use ($amount, $amount_equation) {
                    $query->where('amount', $amount_equation, $amount);
                });
                $constraints++;
            }

            $purchase->latest();
            // return $purchase->dump();
            if($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $purchase
                    ->with([
                        'spend',
                        'registrar:id,name as name'
                        ])->get() :
                $purchase
                    ->with([
                        'spend',
                        'registrar:id,name_dr as name'
                        ])->get() ;
        }

        return view('pharmacist-module.purchase.filter');
    }
}
