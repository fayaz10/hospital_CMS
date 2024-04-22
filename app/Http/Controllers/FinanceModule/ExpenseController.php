<?php

namespace App\Http\Controllers\FinanceModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FinanceModule\Expense;

class ExpenseController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:fin_exp_show')->only(['index', 'show', 'filter']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $expenses = Expense::with('currency')->latest()->paginate($limit);
        return view('finance-module.expense.index', compact('expenses'));
    }

    public function show(Expense $expense)
    {
        $expense->load(['spendable', 'currency', 'registrar']);
        // dd($income);
        return view('finance-module.expense.show', compact('expense'));
    }
    
    public function filter()
    {
        if (request()->ajax()) {

            $expense = Expense::query();
            $constraints = 0;

            if (request()->filled('source')) {
                $expense->where('spendable_type', request()->source);
                $constraints++;
            }
            if (request()->filled('registrar_id')) {
                $expense->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('payment_date')) {
                $expense->whereDate('payment_date', request()->payment_date_equation, request()->payment_date);
                $constraints++;
            }
            
            if (request()->filled('from_date')) {
                $expense->whereDate('created_at', request()->from_date_equation, request()->from_date);
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $expense->whereDate('created_at', request()->till_date_equation, request()->till_date);
                $constraints++;
            }
            if (request()->filled('remitter')) {
                $expense->where('remitter', 'like', '%' . request()->remitter . '%');
                $constraints++;
            }
            if (request()->filled('amount')) {
                $expense->where('amount', request()->amount_equation, request()->amount);
                $constraints++;
            }

            $expense->latest();
            // return $expense->dump();
            if($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $expense
                    ->with([
                        'registrar:id,name as name'
                        ])->get() :
                $expense
                    ->with([
                        'registrar:id,name_dr as name'
                        ])->get() ;
        }

        $expenseSources = Expense::distinct()
            ->get(['spendable_type'])
            ->pluck('spendable_type')
            ->toArray();

            // dd($expenseSources);
        return view('finance-module.expense.filter', compact('expenseSources'));
    }
}
