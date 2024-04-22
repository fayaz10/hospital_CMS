<?php

namespace App\Http\Controllers\FinanceModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FinanceModule\Income;

class IncomeController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:fin_inc_show')->only(['index', 'show', 'filter']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $incomesQuery = Income::with('currency')->latest();

        if(auth()->user()->can('fin_report_to_mof'))
            $incomesQuery->whereIn('approved_user', config('iSys.reportUserId'));

        $incomes = $incomesQuery->paginate($limit);
        
        return view('finance-module.income.index', compact('incomes'));
    }

    public function show(Income $income)
    {
        $income->load(['profitable', 'currency', 'registrar']);
        // dd($income);
        return view('finance-module.income.show', compact('income'));
    }
    
    public function filter()
    {
        if (request()->ajax()) {
            // return request()->all();
            $incomes = Income::query();
            $constraints = 0;

            if(auth()->user()->can('fin_report_to_mof'))
                $incomes->whereIn('approved_user', config('iSys.reportUserId'));

            if (request()->filled('source')) {
                $incomes->whereIn('profitable_type', request()->source);
                $constraints++;
            }
            if (request()->filled('registrar_id')) {
                $incomes->whereIn('registrar_id', request()->registrar_id);
                $constraints++;
            }

            if (request()->filled('approver_id')) {
                $incomes->whereIn('approved_user', request()->approver_id);
                $constraints++;
            }

            if (request()->filled('is_approved')) {
                $incomes->whereIn('is_approved', request()->is_approved);
                $constraints++;
            }

            if (request()->filled('payment_date')) {
                $incomes->whereDate('payment_date', request()->payment_date_equation, request()->payment_date);
                $constraints++;
            }
            
            if (request()->filled('from_date')) {
                $incomes->whereDate('created_at', request()->from_date_equation, request()->from_date);
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $incomes->whereDate('created_at', request()->till_date_equation, request()->till_date);
                $constraints++;
            }
            if (request()->filled('remitter')) {
                $incomes->where('remitter', 'like', '%' . request()->remitter . '%');
                $constraints++;
            }
            if (request()->filled('amount')) {
                $incomes->where('amount', request()->amount_equation, request()->amount);
                $constraints++;
            }

            $incomes->latest();
            // return $incomes->dump();
            if($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $incomes
                    ->with([
                        'registrar:id,name as name',
                        'approvedBy:id,name as name',
                        ])->get() :
                $incomes
                    ->with([
                        'registrar:id,name_dr as name',
                        'approvedBy:id,name_dr as name',
                        ])->get() ;
        }

        $incomeSources = Income::distinct()
            ->get(['profitable_type'])
            ->makeHidden(['taxes', 'totalAmount'])
            ->pluck('profitable_type')
            ->toArray();

        return view('finance-module.income.filter', compact('incomeSources'));
    }
}
