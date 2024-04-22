<?php

namespace App\Http\Controllers\Pharmacist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacist\MedicineStockOut;

class MedicineStockOutController extends Controller
{

    public function show(MedicineStockOut $stock_out)
    {
        if (request()->ajax()) {
            return $stock_out->load('medicine')->toJson();
        }
    }

    public function store()
    {
        $this->validate(request(), [
            'medicine_id' => 'required|min:1',
            'prescription_id' => 'required|min:1',
            'quantity' => 'required|min:1',
        ]);

        $stock = \App\Models\Pharmacist\Medicine::findOrFail(request()->medicine_id)->store;

        $profit = \App\Models\Pharmacist\Prescription::findOrFail(request()->prescription_id)->profit;

        // Saving the Item to list
        $newItem = new MedicineStockOut();
        $newItem->medicine_id = request()->medicine_id;
        $newItem->prescription_id = request()->prescription_id;
        $newItem->currency_id = $stock->currency_id;
        $newItem->unit_price = $stock->unit_price;
        $newItem->quantity = request()->quantity;
        $newItem->registrar_id = auth()->id();

        \DB::beginTransaction();

        $profit->amount += (request()->quantity * $stock->unit_price);
        $profit->save();

        $stock->quantity -= request()->quantity;
        $stock->save();

        $newItem->save();

        \DB::commit();

        return redirect(route('prescription.show', [$newItem->prescription_id]))
            ->with([
                'alert' => "created",
                'class' => 'alert-info'
            ]);
    }

    
    public function update(MedicineStockOut $stock_out)
    {
        $this->validate(request(), [
            'quantity' => 'required|min:1',
        ]);

        $old['quantity'] = $stock_out->quantity;
        $old['unit_price'] = $stock_out->unit_price;

        // the medicine stock
        $stock = $stock_out->medicine->store;

        // the purchase profit
        $profit = $stock_out->prescription->profit;

        \DB::beginTransaction();

        // update the purchase in database
        $stock_out->update([
            'quantity' => request()->quantity,
            'unit_price' => $stock->unit_price,
        ]);

        $stock->quantity += $old['quantity'];
        $stock->quantity -= $stock_out->quantity;
        $stock->save();

        $profit->amount -= ($old['quantity'] * $old['unit_price']);
        $profit->amount += ($stock_out->quantity * $stock->unit_price);

        $profit->save();

        \DB::commit();

        return redirect(route('prescription.show', [$stock_out->prescription_id]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand'
            ]);
    }

    public function destroy(MedicineStockOut $stock_out)
    {
        
        // the medicine stock
        $stock = $stock_out->medicine->store;

        // the purchase profit
        $profit = $stock_out->prescription->profit;

        \DB::beginTransaction();

        $profit->amount -= ($stock_out->quantity * $stock_out->unit_price);
        $profit->save();

        $stock->quantity += $stock_out->quantity;

        $stock->save();

        $stock_out->delete();

        \DB::commit();

        return redirect(route('prescription.show', [request()->prescription_id]))
            ->with([
                'alert' => "deleted",
                'class' => 'alert-danger'
            ]);
    }

}
