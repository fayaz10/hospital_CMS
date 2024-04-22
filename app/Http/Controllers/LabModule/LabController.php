<?php

namespace App\Http\Controllers\LabModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LabModule\Experiment;

class LabController extends Controller
{
    public function index()
    {
        // dd(\Carbon\Carbon::now('Asia/Kabul')->startOfYear()->format('Y-m-d H:i:s'));
        $expYearCollection = Experiment::where(
            'created_at',
            '>=',
            \Carbon\Carbon::now('Asia/Kabul')->startOfYear()->format('Y-m-d H:i:s')
        )
            ->get();

        $expYearCount = $expYearCollection->count();

        $expMonthCount = $expYearCollection->where(
            'created_at',
            '>=',
            \Carbon\Carbon::now('Asia/Kabul')->startOfMonth()->format('Y-m-d H:i:s')
        )
            ->count();

        $expTodayCount = $expYearCollection->where(
            'created_at',
            '>=',
            \Carbon\Carbon::now('Asia/Kabul')->startOfDay()->format('Y-m-d H:i:s')
        )
            ->count();

        return view(
            'lab-module.dashboard',
            compact(
                'expYearCount',
                'expMonthCount',
                'expTodayCount'
            )
        );
    }
}
