<?php

namespace App\Http\Controllers\Receptionist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receptionist\Doctor;
use App\Models\Receptionist\Visit;
use App\Models\FinanceModule\Income;
use App\Models\Receptionist\RefundNote;

class ReceptionistController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:rec_rep_daily')->only(['daily']);
        $this->middleware('permission:rec_rep_advance')->only(['index']);
    }

    public function dashboard()
    {
        $doctorsCount = Doctor::count();

        $patientsInthisMonth = Visit::where('created_at', '>=', \Carbon\Carbon::now('Asia/Kabul')->startOfMonth()->format('Y-m-d H:i:s'))->get();

        $patientsInthisMonthCount = $patientsInthisMonth->count();
        $patientsInthisWeekCount = $patientsInthisMonth->where('created_at', '>=', \Carbon\Carbon::now('Asia/Kabul')->startOfWeek()->format('Y-m-d H:i:s'))->count();
        $patientsInthisDayCount = $patientsInthisMonth->where('created_at', '>=', \Carbon\Carbon::now('Asia/Kabul')->startOfDay()->format('Y-m-d H:i:s'))->count();

        return view(
            'receptionist-module.dashboard',
            compact(
                'doctorsCount',
                'patientsInthisMonthCount',
                'patientsInthisWeekCount',
                'patientsInthisDayCount'
            )
        );
    }

    public function visitGraph()
    {
        $subs = request()->has('sub') && request()->sub <= 12 ? (int) request()->sub : 4;

        $visits = Visit::where('created_at', '>=', \Carbon\Carbon::now('Asia/Kabul')->subMonths($subs)->startOfMonth()->format('Y-m-d H:i:s'))->get();

        $now = \Carbon\Carbon::now('Asia/Kabul');

        $months = [];
        $data = [];

        for ($i = 0; $i < $subs; $i++) {
            if ($i == 0) {
                $months[] = $now->format('F');

                $data[] = $visits->whereBetween('created_at', [
                    $now->startOfMonth()->format('Y-m-d H:i:s'),
                    $now->endOfMonth()->format('Y-m-d H:i:s')
                ])
                    ->count();

                $now->startOfMonth();

                continue;
            }

            $months[] = $now->subMonths(1)->format('F');

            $data[] = $visits->whereBetween('created_at', [
                $now->startOfMonth()->format('Y-m-d H:i:s'),
                $now->endOfMonth()->format('Y-m-d H:i:s')
            ])
                ->count();

            $now->startOfMonth();

        }

        return ['months' => array_reverse($months), 'data' => array_reverse($data)];
    }

    
    public function index()
    {
        if (request()->ajax()) {

            $incomes = Income::query();
            $constraints = 0;
            $notes = RefundNote::query();

            if (request()->filled('source')) {
                $incomes->whereIn('profitable_type', request()->source);
                $notes->whereIn('source_type', request()->source);
                $constraints++;
            }
            if (request()->filled('registrar_id')) {
                $incomes->whereIn('registrar_id', request()->registrar_id);
                $constraints++;
            }
            if (request()->filled('payment_date')) {
                $incomes->whereDate('payment_date', request()->payment_date_equation, request()->payment_date);
                $constraints++;
            }

            if (request()->filled('approver_id')) {
                $incomes->whereIn('approved_user', request()->approver_id);
                $notes->whereIn('approved_user', request()->approver_id);
                $constraints++;
            }

            if (request()->filled('is_approved')) {
                $incomes->whereIn('is_approved', request()->is_approved);
                $constraints++;
            }
            
            if (request()->filled('from_date')) {
                $from_date = request()->from_date . ( request()->filled('from_time') ? ' '. request()->from_time : null);
                $incomes->whereDate('created_at', request()->from_date_equation ?? '>=', $from_date );
                $notes->whereDate('created_at', request()->from_date_equation ?? '>=', $from_date );
                $constraints++;
            }
            if (request()->filled('till_date')) {
                $till_date = request()->till_date . (request()->filled('till_time') ? ' '. request()->till_time : null);
                $incomes->whereDate('created_at', request()->till_date_equation ?? '<=', $till_date);
                $notes->whereDate('created_at', request()->till_date_equation ?? '<=', $till_date);
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
            
            if($constraints <= 0)
                return [];

            $incomesCollection = app()->isLocale('en') ? $incomes
                                                            ->with([
                                                                'registrar:id,name as name',
                                                                'approvedBy:id,name as name',
                                                            ])->get()
                                                        : $incomes
                                                            ->with([
                                                                'registrar:id,name_dr as name',
                                                                'approvedBy:id,name_dr as name',
                                                            ])->get();
            
            // add refund to list
            foreach($notes->get() as $note){
                $refundIncome = $note->source;
                $refundIncome->amount = $note->type == 'minus' ? -$note->amount : $note->amount ;
                $refundIncome->tax = 0;
                $refundIncome->is_refund = true;
                $refundIncome->approved_user = $note->approved_user;

                $incomesCollection->push(app()->isLocale('en') 
                    ? $refundIncome->load('registrar:id,name as name', 'approvedBy:id,name as name')
                    : $refundIncome->load('registrar:id,name_dr as name', 'approvedBy:id,name_dr as name')
                );
            }

            return
                [
                    'data' => $incomesCollection,
                    'notes' => 0
                ];
        }

        $incomeSources = Income::distinct()
            ->get(['profitable_type'])
            ->makeHidden(['taxes', 'totalAmount'])
            ->pluck('profitable_type')
            ->toArray();

        return view('receptionist-module.reports.filter', compact('incomeSources'));
    }

    
    public function daily()
    {
        return view('receptionist-module.reports.daily');
    }

    
}
