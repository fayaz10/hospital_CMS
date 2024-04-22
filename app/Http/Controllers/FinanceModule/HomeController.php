<?php

namespace App\Http\Controllers\FinanceModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FinanceModule\Expense;
use App\Models\FinanceModule\Income;

class HomeController extends Controller
{
    public function index()
    {
        return view('finance-module.home');
    }

    public function inExGraph()
    {
        $subs = request()->has('sub') && request()->sub <= 6 ? (int) request()->sub : 3;

        $incomesQuery = Income::where('payment_date', '>=', \Carbon\Carbon::now('Asia/Kabul')
                            ->subMonths($subs)
                            ->startOfMonth()
                            ->format('Y-m-d'));

        if(auth()->user()->can('fin_report_to_mof'))
            $incomesQuery->whereIn('approved_user', config('iSys.reportUserId'));

        $incomes = $incomesQuery->get();

        // dd($incomes);

        $expenses = Expense::where('payment_date', '>=', \Carbon\Carbon::now('Asia/Kabul')->subMonths($subs)->startOfMonth()->format('Y-m-d'))->get();

        $now = \Carbon\Carbon::now('Asia/Kabul');

        $months = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 0; $i < $subs; $i++) {
            if ($i == 0) {
                $months[] = $now->format('F');

                $incomeData[] = $incomes->whereBetween('payment_date', [
                    $now->startOfMonth()->format('Y-m-d'),
                    $now->endOfMonth()->format('Y-m-d')
                ])
                    ->sum('totalAmount');

                $expenseData[] = $expenses->whereBetween('payment_date', [
                    $now->startOfMonth()->format('Y-m-d'),
                    $now->endOfMonth()->format('Y-m-d')
                ])
                    ->sum('amount');

                $now->startOfMonth();

                continue;
            }

            $months[] = $now->subMonths(1)->format('F');

            $incomeData[] = $incomes->whereBetween('payment_date', [
                $now->startOfMonth()->format('Y-m-d'),
                $now->endOfMonth()->format('Y-m-d')
            ])
                ->sum('totalAmount');

            $expenseData[] = $expenses->whereBetween('payment_date', [
                $now->startOfMonth()->format('Y-m-d'),
                $now->endOfMonth()->format('Y-m-d')
            ])
                ->sum('amount');

            $now->startOfMonth();
        }

        return [
            'months' => array_reverse($months),
            'income' => array_reverse($incomeData),
            'expense' => array_reverse($expenseData)
        ];
    }

    public function incomeGraph()
    {
        $subs = request()->has('sub') && request()->sub <= 6 ? (int) request()->sub : 1;

        $incomesQuery = Income::where(
                                'payment_date',
                                '>=',
                                \Carbon\Carbon::now('Asia/Kabul')->subMonths(($subs > 1 ? $subs : 0))->startOfMonth()->format('Y-m-d')
                            );

        if(auth()->user()->can('fin_report_to_mof'))
            $incomesQuery->whereIn('approved_user', config('iSys.reportUserId'));

        $incomes = $incomesQuery->get();

        $groupedIncomes = $incomes->groupBy('profitable_type');

        $expenses = Expense::where(
            'payment_date',
            '>=',
            \Carbon\Carbon::now('Asia/Kabul')->subMonths(($subs > 1 ? $subs : 0))->startOfMonth()->format('Y-m-d')
        )->get();

        $groupedExpenses = $expenses->groupBy('spendable_type');
        
        $incomeData = [];
        $incomeTypes = [];
        
        foreach ($groupedIncomes as $key => $incomeCollection) {
            $incomeTypes[] = basename($key, '\\');
            $incomeData[] = $incomeCollection->sum('totalAmount');
        }
        
        $expenseData = [];
        $expenseTypes = [];
        
        foreach ($groupedExpenses as $key => $expenseCollection) {
            $expenseTypes[] = basename($key, '\\');
            $expenseData[] = $expenseCollection->sum('amount');
        }

        return [
            'incomeData' => $incomeData,
            'incomeTypes' => $incomeTypes,

            'expenseData' => $expenseData,
            'expenseTypes' => $expenseTypes,
        ];
    }
}
