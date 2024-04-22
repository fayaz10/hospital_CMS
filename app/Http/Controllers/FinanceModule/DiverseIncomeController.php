<?php

namespace App\Http\Controllers\FinanceModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FinanceModule\DiverseIncome;
use App\Models\FinanceModule\Income;

class DiverseIncomeController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:fin_din_show')->only(['index', 'show']);
        $this->middleware('permission:fin_din_create')->only(['create', 'store']);
        $this->middleware('permission:fin_din_edit')->only(['edit', 'update']);
        $this->middleware('permission:fin_din_delete')->only(['destroy']);
    }
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $incomesQuery = DiverseIncome::with(['profit', 'profit.currency', 'category'])
            ->latest();
        
        if(auth()->user()->can('fin_report_to_mof'))
            $incomesQuery->whereHas('profit', function($q){
                $q->whereIn('approved_user', config('iSys.reportUserId'));
            });

        $incomes = $incomesQuery->paginate($limit);

        return view('finance-module.diverse-income.index', compact('incomes'));
    }

    public function create()
    {
        return view('finance-module.diverse-income.create');
    }

    public function show(DiverseIncome $diverse_income)
    {
        $diverse_income->load(['profit', 'profit.currency', 'category']);
        return view('finance-module.diverse-income.show', compact('diverse_income'));
    }

    public function store()
    {
        $this->validate(request(), [
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|gt:1',
            'currency_id' => 'required|numeric',
            'type' => 'required',
            'recipient' => 'required',
            'category_id' => 'required|numeric',
            'subject' => 'required',
            'discount' => 'nullable|numeric|between:0,100|required_with:member_id',
        ]);

        \DB::beginTransaction();

        $DIncome = DiverseIncome::create([
            'type' => request()->type,
            'category_id' => request()->category_id,
            'subject' => request()->subject,
            'registrar_id' => auth()->id(),
            'description' => request()->description,
            'discount' => request()->discount,
            'membership_id' => request()->member_id,
        ]);

        
        $discoutAmount = 0;
        if (request()->has('discount'))
            $discoutAmount = \App\iSys\Services\IncomeFormatter::toAmount(request()->amount, request()->discount);

        $newIncome = new Income([
            'payment_date' => request()->payment_date,
            'amount' => request()->amount - $discoutAmount,
            'currency_id' => request()->currency_id,
            'recipient' => request()->recipient,
            'tax' => config("iSys.tax.DiverseIncome", config("iSys.tax.default")),
            'registrar_id' => auth()->id(),
            'approved_user' => auth()->id(),
            'is_approved' => 1,
        ]);

        // save the all incomes
        $DIncome->profit()->save($newIncome);

        \DB::commit();

        return redirect(route('diverse-income.index'))->with([
            'alert' => "performed",
            'class' => 'alert-info'
        ]);
    }

    public function edit(DiverseIncome $diverse_income)
    {
        $diverse_income->load(['profit', 'profit.currency', 'category']);
        return view('finance-module.diverse-income.edit', compact('diverse_income'));
    }

    public function update(DiverseIncome $diverse_income)
    {
        $this->validate(request(), [
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|gt:1',
            'currency_id' => 'required|numeric',
            'type' => 'required',
            'recipient' => 'required',
            'category_id' => 'required|numeric',
            'subject' => 'required',
        ]);

        \DB::beginTransaction();

        $diverse_income->update([
            'type' => request()->type,
            'category_id' => request()->category_id,
            'subject' => request()->subject,
            'description' => request()->description,
        ]);

        $diverse_income->profit()->update([
            'payment_date' => request()->payment_date,
            'amount' => request()->amount,
            'currency_id' => request()->currency_id,
            'recipient' => request()->recipient,
        ]);

        \DB::commit();

        return redirect(route('diverse-income.index'))->with([
            'alert' => "edited",
            'class' => 'alert-brand'
        ]);
    }

    public function search()
    {

        if (request()->ajax())
            return DiverseIncome::search(request()->term)
                ->get();
    }

    public function filter()
    {
        if (request()->ajax()) {

            $incomes = DiverseIncome::query();
            $constraints = 0;

            if(auth()->user()->can('fin_report_to_mof'))
                $incomes->whereHas('profit', function($q){
                    $q->whereIn('approved_user', config('iSys.reportUserId'));
                });

            if (request()->filled('registrar_id')) {
                $incomes->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('category')) {
                $incomes->where('category_id', request()->category);
                $constraints++;
            }
            if (request()->filled('payment_date')) {
                $incomes->whereHas('profit', function($q){
                    $q->whereDate('payment_date', request()->payment_date_equation, request()->payment_date);
                });
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
            if (request()->filled('subject')) {
                $incomes->where('subject', 'like', '%' . request()->subject . '%');
                $constraints++;
            }
            if (request()->filled('type')) {
                $incomes->where('type', 'like', '%' . request()->type . '%');
                $constraints++;
            }
            if (request()->filled('recipient')) {
                $recipient = request()->recipient;
                $incomes->whereHas('profit', function ($query) use ($recipient) {
                    $query->where('recipient', 'like', '%' . $recipient . '%');
                });
                $constraints++;
            }
            if (request()->filled('amount')) {
                $amount = request()->amount;
                $incomes->whereHas('profit', function ($query) use ($amount) {
                    $query->where('amount', request()->amount_equation, request()->amount);
                });
                $constraints++;
            }

            $incomes->latest();
            // return $incomes->dump();
            if ($constraints <= 0)
                return [];

            return
                app()->isLocale('en') ?
                $incomes
                ->with([
                    'category:id,label_en as label',
                    'profit',
                    'registrar:id,name as name',
                ])->get() : $incomes
                ->with([
                    'category:id,label_dr as label',
                    'profit',
                    'registrar:id,name_dr as name'
                ])->get();
        }

        return view('finance-module.diverse-income.filter');
    }

    public function destroy(DiverseIncome $diverse_income)
    {
        \DB::beginTransaction();

        $diverse_income->profit->delete();
        $diverse_income->delete();

        \DB::commit();

        return redirect(route('diverse-income.index'))->with([
            'alert' => "deleted",
            'class' => 'alert-danger'
        ]);
    }
}
