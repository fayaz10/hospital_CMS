<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Pharmacist\Medicine;
use App\Models\Pharmacist\PurchaseList;

class PurchaseListController extends Controller
{
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        // $stock = Medicine::store()
        //     ->paginate($limit);

        $stock = Medicine::with([
            'store',
            'type',
            'unit',
            'store.currency'
        ])
            ->paginate($limit);

        // dd($stock);

        return view('pharmacist-module.stock.index', compact('stock'));
    }

    public function show(PurchaseList $purchase_list)
    {
        if (request()->ajax()) {
            // $test_completion->load('type', 'unit', 'store', 'store.currency');
            return $purchase_list->load('medicine')->toJson();
        }
    }

    public function store()
    {
        $this->validate(request(), [
            'medicine_id' => 'required|min:1',
            'purchase_id' => 'required|min:1',
            'quantity' => 'required|min:1',
            'total_price' => 'required|min:1',
        ]);

        $stock = \App\Models\Pharmacist\Medicine::findOrFail(request()->medicine_id)->store;

        $expense = \App\Models\Pharmacist\MedicinePuchase::findOrFail(request()->purchase_id)->spend;

        // Saving the Item to list
        $newItem = new PurchaseList();
        $newItem->medicine_id = request()->medicine_id;
        $newItem->purchase_id = request()->purchase_id;
        $newItem->currency_id = $expense->currency_id;
        $newItem->total_price = request()->total_price;
        $newItem->quantity = request()->quantity;
        $newItem->benefits = config("iSys.benefits.medicinePurchase", config("iSys.benefits.default"));

        \DB::beginTransaction();

        $expense->amount += request()->total_price;
        $expense->save();

        $stock->quantity += request()->quantity;

        $stock->unit_price = \App\iSys\Services\ExpenseHelper::unitPriceWithBenefits(request()->total_price, request()->quantity);

        $stock->save();

        $newItem->save();

        \DB::commit();

        return redirect(route('medicine-purchase.show', [$newItem->purchase_id]))
            ->with([
                'alert' => "created",
                'class' => 'alert-info'
            ]);
    }

    public function update(PurchaseList $purchase_list)
    {
        $this->validate(request(), [
            'quantity' => 'required|min:1',
            'total_price' => 'required|min:1',
        ]);

        $old['quantity'] = $purchase_list->quantity;
        $old['total_price'] = $purchase_list->total_price;

        // the medicine stock
        $stock = $purchase_list->medicine->store;

        // the purchase profit
        $expense = $purchase_list->purchase->spend;

        \DB::beginTransaction();

        // update the purchase in database
        $purchase_list->update(request()->only(['quantity', 'total_price']));

        $stock->quantity -= $old['quantity'];
        $stock->quantity += $purchase_list->quantity;

        $stock->unit_price = \App\iSys\Services\ExpenseHelper::unitPriceWithBenefits($purchase_list->total_price, $purchase_list->quantity);

        $stock->save();

        $expense->amount -= $old['total_price'];
        $expense->amount += $purchase_list->total_price;

        $expense->save();

        \DB::commit();

        return redirect(route('medicine-purchase.show', [$purchase_list->purchase_id]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand'
            ]);
    }

    public function destroy(PurchaseList $purchase_list)
    {
        
        // the medicine stock
        $stock = $purchase_list->medicine->store;

        // the purchase profit
        $expense = $purchase_list->purchase->spend;

        \DB::beginTransaction();

        $expense->amount -= $purchase_list->total_price;
        $expense->save();

        $stock->quantity -= $purchase_list->quantity;

        $stock->save();

        $purchase_list->delete();

        \DB::commit();

        return redirect(route('medicine-purchase.show', [request()->purchase_id]))
            ->with([
                'alert' => "deleted",
                'class' => 'alert-danger'
            ]);
    }
}
