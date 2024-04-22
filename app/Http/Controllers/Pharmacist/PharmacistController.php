<?php

namespace App\Http\Controllers\Pharmacist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacist\Medicine;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Pharmacist\MedicinePuchase;

class PharmacistController extends Controller
{
    public function dashboard()
    {
        $medicinesCount = \App\Models\Pharmacist\Medicine::count();

        //medicine purchase in this monthe
        $medicinePurchaseInThisMonth = \App\Models\Pharmacist\MedicinePuchase::whereDate(
            'purchase_date',
            '>=',
            \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')
        )->get();

        //medicine purchase in this week
        $medicinePurchaseInThisWeek = $medicinePurchaseInThisMonth->where(
            'purchase_date',
            '>=',
            \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')
        );


        //medicine purchase in today
        $medicinePurchaseToday = $medicinePurchaseInThisMonth->where(
            'purchase_date',
            '>=',
            \Carbon\Carbon::now()->startOfDay()->format('Y-m-d')
        );

        // count all mediciens that are less than 10
        $medicineStock = Medicine::whereHas('store', function (Builder $query) {
            $query->where('quantity', '<', 10);
        })->get();

        // show medicienes that are not available in stock
        $medicineStockZero = Medicine::whereHas('store', function (Builder $query) {
            $query->where('quantity', '=', 0);
        })->get();

        // prescription in this month
        $prescriptions = \App\Models\Pharmacist\Prescription::whereDate(
            'created_at',
            '>=',
            \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d H:i:s')
        )->get();

        return view('pharmacist-module.dashboard', compact(
            'medicinesCount',
            'medicinePurchaseInThisWeek',
            'medicinePurchaseInThisMonth',
            'medicinePurchaseToday',
            'medicineStockZero',
            'medicineStock',
            'prescriptions'
        ));
    }
}
