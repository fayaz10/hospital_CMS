<?php

namespace App\Http\Controllers\FinanceModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FinanceModule\DiverseExpense;
use App\Models\FinanceModule\Expense;

class DiverseExpenseController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:fin_dex_show')->only(['index', 'show']);
        $this->middleware('permission:fin_dex_create')->only(['create', 'store']);
        $this->middleware('permission:fin_dex_edit')->only(['edit', 'update']);
        $this->middleware('permission:fin_dex_delete')->only(['destroy']);

    }
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $expenses = DiverseExpense::with(['spend', 'spend.currency', 'category'])
            ->latest()
            ->paginate($limit);

        return view('finance-module.diverse-expense.index', compact('expenses'));
    }

    public function create()
    {
        return view('finance-module.diverse-expense.create');
    }

    public function show(DiverseExpense $diverse_expense)
    {
        $diverse_expense->load(['spend', 'spend.currency', 'category']);
        return view('finance-module.diverse-expense.show', compact('diverse_expense'));
    }

    public function store()
    {
        $this->validate(request(), [
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|gt:1',
            'currency_id' => 'required|numeric',
            'type' => 'required',
            'remitter' => 'required',
            'category_id' => 'required',
            'reason' => 'required',
        ]);

        \DB::beginTransaction();

        $DExpense = DiverseExpense::create([
            'type' => request()->type,
            'category_id' => $this->categrorable(request()->category_id),
            'reason' => request()->reason,
            'registrar_id' => auth()->id(),
            'description' => request()->description,
        ]);

        $newExpense = new Expense([
            'payment_date' => request()->payment_date,
            'amount' => request()->amount,
            'currency_id' => request()->currency_id,
            'remitter' => request()->remitter,
            'registrar_id' => auth()->id(),
        ]);

        // save the all incomes
        $DExpense->spend()->save($newExpense);

        \DB::commit();

        return redirect(route('diverse-expense.index'))->with([
            'alert' => "performed",
            'class' => 'alert-info'
        ]);
    }

    public function edit(DiverseExpense $diverse_expense)
    {
        $diverse_expense->load(['spend', 'spend.currency', 'category']);
        return view('finance-module.diverse-expense.edit', compact('diverse_expense'));
    }

    public function update(DiverseExpense $diverse_expense)
    {
        $this->validate(request(), [
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|gt:1',
            'currency_id' => 'required|numeric',
            'type' => 'required',
            'remitter' => 'required',
            'category_id' => 'required',
            'reason' => 'required',
        ]);

        \DB::beginTransaction();

        $diverse_expense->update([
            'type' => request()->type,
            'category_id' => $this->categrorable(request()->category_id),
            'reason' => request()->reason,
            'description' => request()->description,
        ]);

        $diverse_expense->spend()->update([
            'payment_date' => request()->payment_date,
            'amount' => request()->amount,
            'currency_id' => request()->currency_id,
            'remitter' => request()->remitter,
        ]);

        \DB::commit();

        return redirect(route('diverse-expense.index'))->with([
            'alert' => "edited",
            'class' => 'alert-brand'
        ]);
    }

    public function search()
    {

        if (request()->ajax())
            return DiverseExpense::search(request()->term)
                ->get();
    }

    public function filter()
    {
        if (request()->ajax()) {

            $incomes = DiverseExpense::query();
            $constraints = 0;

            if (request()->filled('registrar_id')) {
                $incomes->where('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('category')) {
                $incomes->where('category_id', request()->category);
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
            if (request()->filled('reason')) {
                $incomes->where('reason', 'like', '%' . request()->reason . '%');
                $constraints++;
            }
            if (request()->filled('type')) {
                $incomes->where('type', 'like', '%' . request()->type . '%');
                $constraints++;
            }
            if (request()->filled('remitter')) {
                $remitter = request()->remitter;
                $incomes->whereHas('spend', function ($query) use ($remitter) {
                    $query->where('remitter', 'like', '%' . $remitter . '%');
                });
                $constraints++;
            }
            if (request()->filled('amount')) {
                $amount = request()->amount;
                $incomes->whereHas('spend', function ($query) use ($amount) {
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
                    'spend',
                    'registrar:id,name as name',
                ])->get() : $incomes
                ->with([
                    'category:id,label_dr as label',
                    'spend',
                    'registrar:id,name_dr as name'
                ])->get();
        }

        return view('finance-module.diverse-expense.filter');
    }

    public function destroy(DiverseExpense $diverse_expense)
    {
        \DB::beginTransaction();

        $diverse_expense->spend->delete();
        $diverse_expense->delete();

        \DB::commit();

        return redirect(route('diverse-expense.index'))->with([
            'alert' => "deleted",
            'class' => 'alert-danger'
        ]);
    }

    
    public function categrorable($category)
    {
        if (is_numeric($category)) return $category;

        $id = \DB::table('diverse_category')->insertGetId([
                'name' => $category,
                'label_dr' => $category,
                'label_en' => $category,
                'type' => 'expense',
            ]);

        return $id;
    }
}
