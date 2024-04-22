<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Receptionist\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\FinanceModule\DiverseCategory;

class DoctorController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:rec_doc_show')->only(['index', 'show']);
        $this->middleware('permission:rec_doc_create')->only(['create', 'store']);
        $this->middleware('permission:rec_doc_edit')->only(['edit', 'update']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $doctors = Doctor::with('currency')
            ->latest()
            ->paginate($limit);

        // dd($doctors);

        return view('receptionist-module.doctor.index', compact('doctors'));
    }

    public function show(Doctor $doctor)
    {
        return view('receptionist-module.doctor.show', compact('doctor'));
    }

    public function create()
    {
        return view('receptionist-module.doctor.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'specialist' => 'required|min:3',
            'visit_fee' => 'required|numeric',
            'currency_id' => 'required',
            'email' => 'required_with:make_user',
            'img_path' => 'max:10000',
        ]);

        $newDoc = Doctor::create([
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'specialist' => request()->specialist,
            'visit_fee' => request()->visit_fee,
            'currency_id' => request()->currency_id,
            'email' => request()->email,
            'registrar_id' => auth()->id(),
            'photo' => request()->hasFile('img_path') ?
            request()->img_path->move('doctor_pic', request()->first_name . Str::uuid()->toString() . '.' . request()->img_path->getClientOriginalExtension()) : null,
        ]);

        if (request()->has('make_user')) {
            \App\User::create([
                'name' => $newDoc->first_name . ' ' . $newDoc->last_name,
                'name_dr' => $newDoc->first_name . ' ' . $newDoc->last_name,
                'email' => $newDoc->email,
                'password' => bcrypt('user@iSys'),
                'status' => 1,
                'user_id' => auth()->id(),
                'img_path' => $newDoc->photo,
            ]);
        }

        return redirect(route('doctor.show', [$newDoc->id]))->with([
            'alert' => "created",
            'class' => 'alert-info',
        ]);
    }

    public function edit(Doctor $doctor)
    {
        return view('receptionist-module.doctor.edit', compact('doctor'));
    }

    public function update(Doctor $doctor)
    {
        $this->validate(request(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'specialist' => 'required|min:3',
            'visit_fee' => 'required|numeric',
            'currency_id' => 'required',
        ]);

        $doctor->update(request()->except(['_token', '_method']));

        if (request()->hasFile('img_path')) {
            $doctor->update([
                'photo' => request()->img_path->move('doctor_pic', request()->first_name . Str::uuid()->toString() . '.' . request()->img_path->getClientOriginalExtension()),
            ]);
        }

        return redirect(route('doctor.show', [$doctor->id]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand',
            ]);
    }

    public function filter()
    {
        if (request()->ajax()) {
            return Doctor::with('department:id,name_en')
                ->where('subject', 'like', '%' . request()->term . '%')
                ->get()
                ->toJson();
        }

    }

    public function search()
    {
        // return request()->term;
        if (request()->ajax()) {
            return Doctor::search(request()->term)
                ->get();
        }

    }

    public function incomeBalance()
    {
        // get All income resources
        $incomeSources = \App\Models\FinanceModule\Income::distinct()
            ->get(['profitable_type'])
            ->makeHidden(['taxes', 'totalAmount'])
            ->pluck('profitable_type')
            ->toArray();

        $incomeQuery = \App\Models\FinanceModule\Income::query();
        $constraints = 0;
        $printingResult = null;

        if (request()->filled('doctors')) {

            $docProfitableIncomes = array_filter($incomeSources, function ($item) {
                //get the object
                $type = '\\' . $item;
                $model = new $type;

                return \Schema::hasColumn($model->getTable(), 'doctor_id');
            });

            $incomeQuery->whereHasMorph('profitable', $docProfitableIncomes, function ($query) {
                $query->whereIn('doctor_id', request()->doctors);
            });
        }
        if (request()->filled('from_date')) {
            $from_date = request()->from_date . (request()->filled('from_time') ? ' ' . request()->from_time : null);
            // dd($from_date);
            $incomeQuery->whereDate('created_at', '>=', request()->from_date);
            $constraints++;
        }
        if (request()->filled('till_date')) {
            $incomeQuery->whereDate('created_at', '<=', request()->till_date);
            $constraints++;
        }
        if (request()->filled('is_approved')) {
            $incomeQuery->where('is_approved', 1);
            $constraints++;
        }

        if (request()->filled('doctors')) {
            $incomes = $incomeQuery
                ->with([
                    'profitable',
                ])->get();

            // dd($incomes);
            $groupedByDocIds = $incomes->groupBy('profitable.doctor_id');

            $doctors = Doctor::find(array_keys($groupedByDocIds->toArray()));

            // store the final result

            $printingResult = $groupedByDocIds->mapWithKeys(function ($item, $doctorId) use ($doctors) {
                // find the doctor from collection
                $doc = ($doctors->where('id', $doctorId))->first();

                $sortedModels = $item->sortByDesc(function ($model, $index) {
                    return $model->created_at;
                });

                $groupedByIncomeSources = $sortedModels->groupBy('profitable_type');

                $result = $groupedByIncomeSources->mapWithKeys(function ($sources, $key) {

                    if($key == 'App\Models\FinanceModule\DiverseIncome'){

                        $categories = DiverseCategory::all();

                        $diverseIncomeCategory = $sources->groupBy('profitable.category_id');

                        $eachCategory = $diverseIncomeCategory->mapWithKeys(function ($diverseIncome, $id) use ($categories, $key){

                            $category = $categories->where('id', $id)->first();
                            
                            return [__('finance.' . strtolower(basename($key, '\\'))) . ' (' . $category->name . ')' => [
                                'from' => optional($diverseIncome->first()->created_at)->format('Y-m-d'),
                                'to' => optional($diverseIncome->last()->created_at)->format('Y-m-d'),
                                'amount' => $diverseIncome->sum('totalAmount'),
                                'tax' => round($diverseIncome->sum('taxes')),
                            ]];
                        });

                        return $eachCategory;
                    }

                    return [__('finance.' . strtolower(basename($key, '\\'))) => [
                        'from' => optional($sources->first()->created_at)->format('Y-m-d'),
                        'to' => optional($sources->last()->created_at)->format('Y-m-d'),
                        'amount' => $sources->sum('totalAmount'),
                        'tax' => round($sources->sum('taxes')),
                    ]];
                });

                return [$doc->name => $result];
            });
        }
        // return $mapped->toArray();
        return view('receptionist-module.doctor.balance', compact('incomeSources', 'printingResult'));
    }
}
