<?php

namespace App\Http\Controllers;

use App\Approvable;
use Illuminate\Http\Request;

class ApprovableController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:rec_apr_show')->only(['index', 'show']);
        $this->middleware('permission:rec_apr_approve')->only(['approve']);
        $this->middleware('permission:rec_apr_reject')->only(['reject']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        // get the selected tav
        $tab = request()->has('tab') ? request()->tab : 'all-approvales';

        // Searched Item
        $searches = !request()->filled('term') ? null : Approvable::with(['approvedBy', 'approvable', 'approvable.profit'])
            ->where('record_no', 'like', '%' . request()->term . '%')
            ->latest('updated_at')
            ->paginate($limit, ['*'], 'searchingPage');

            
        // all approvales
        $approvables = Approvable::with(['approvedBy', 'approvable', 'approvable.profit'])
            ->latest('updated_at')
            ->paginate($limit);

        // all waiting approvales
        $pendingApprovales = Approvable::with(['approvedBy', 'approvable', 'approvable.profit'])
            ->whereNull('is_approved')
            ->latest('updated_at')
            ->paginate($limit, ['*'], 'pendingPage');

        // all payments approved
        $approvedPayments = Approvable::with(['approvedBy', 'approvable', 'approvable.profit'])
            ->where('is_approved', 1)
            ->latest('updated_at')
            ->paginate($limit, ['*'], 'approvedPage');

        // all payments approved
        $rejectedPayments = Approvable::with(['approvedBy', 'approvable', 'approvable.profit'])
            ->where('is_approved', 0)
            ->latest('updated_at')
            ->paginate($limit, ['*'], 'rejectedPage');
        
        return view('receptionist-module.approval.index', 
            compact('approvables', 'tab', 'pendingApprovales', 'approvedPayments', 'rejectedPayments', 'searches'));
    }

    public function approve(Approvable $approval)
    {
        \DB::beginTransaction();
        
        $income = $approval->approvable;
        $income->is_approved = true;
        
        $profit = $income->profit;
        $profit->is_approved = true;
        $profit->approved_user = auth()->id();

        if($profit->created_at->format('Y-m-d') != now()->format('Y-m-d'))
            $profit->refundNotes()->save(new \App\Models\Receptionist\RefundNote([
                'type' => $approval->type == 'refund' ? 'minus' : 'plus',
                'ttl' => now()->addHours(24)->format('Y-m-d H:i:s'),
                'amount' => $approval->amount,
                'approved_user' => auth()->id(),
                'registrar_id' => auth()->id(),
            ]));

        $approval->is_approved = true;
        $approval->approved_user = auth()->id();
        $approval->approved_date = now();

        $profit->save();
        $income->save();
        $approval->save();
        
        \DB::commit();

        return redirect(route('approval.index'))
            ->with([
                'alert' => "performed",
                'class' => 'alert-success'
            ]);
    }

    public function reject(Approvable $approval)
    {
        \DB::beginTransaction();
        
        $source = $approval->approvable;
        
        $profit = $source->profit;

        if ($approval->type == 'new') {

            $approval->is_approved = false;
            $approval->approved_user = auth()->id();
            $approval->approved_date = now();

            
            //for surgery prescription
            if($approval->approvable_type == 'App\Models\Pharmacist\SurgeryPrescription')
                $approval->save();
            else{
                $profit->delete();
    
                $source->delete();
                
                $approval->save();
            }

        }else{

            $state = $approval->state;
            // dd($state);
            if($state && array_key_exists('old', $state))
                foreach($state['old'] as $relation => $data){
                    // dd($data);
                    if(array_key_exists('collection', $data))
                    {
                        $source->{$relation}()->detach();

                        if(empty($data['collection']))
                            continue;

                        foreach($data['collection'] as $model){
                            
                            if(array_key_exists('reversable', $data)){
                                $obj = \App\Models\Pharmacist\Medicine::find($model['id']);
                                foreach($data['reversable'] as $rel => $reversable){
                                    $new = 0;
                                    if(array_key_exists('new', $state))
                                        if(array_key_exists($relation, $state['new']))
                                            if(array_key_exists('collection', $state['new'][$relation]))
                                                foreach($state['new'][$relation]['collection'] as $newModel)
                                                    if($obj->id == $newModel['id'])
                                                        $new = $newModel['pivot'][$reversable];
                                                        
                                    $r = $obj->{$rel};
                                    $r->{$reversable} += $new;
                                    $r->{$reversable} -= $model['pivot'][$reversable];
                                    $r->save();
                                }
                            }
                            
                            unset($model['pivot']['id']);
                            \DB::table($data['pivot'])->insert($model['pivot']);
                        }
                    }
                    else{
                        $fillables = $source->{$relation}->getFillable();
                        // dd($fillables);
                        foreach($data as $attr => $value){
                            if($attr == 'id') continue;
                            if(!in_array($attr, $fillables)) continue;
                            $source->{$relation}->{$attr} = $value;
                        }
                        $source->{$relation}->save();
                    }
                }

            $source->is_approved = true;
            $profit->is_approved = true;

            $profit->save();
            $source->save();

            $approval->is_approved = false;
            $approval->approved_user = auth()->id();
            $approval->approved_date = now();
            $approval->save();
        }

        // dd('working');
        \DB::commit();

        return redirect(route('approval.index'))
            ->with([
                'alert' => "performed",
                'class' => 'alert-success'
            ]);
    }

    public function search()
    {
        if (request()->ajax())
            return Approvable::search(request()->term)
                ->get();
    }
}
