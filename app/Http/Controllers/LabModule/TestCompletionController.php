<?php

namespace App\Http\Controllers\LabModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LabModule\TestCompletion;

class TestCompletionController extends Controller
{
    public function show(TestCompletion $test_completion)
    {
        if (request()->ajax()) {
            // $test_completion->load('type', 'unit', 'store', 'store.currency');
            return $test_completion->toJson();
        }
    }

    public function store()
    {
        // dd(request()->all());
        $this->validate(request(), [
            'experiment_id' => 'required',
            'test_id' => 'required',
        ]);

        //find the test
        $test = \App\Models\LabModule\Test::findOrFail(request()->test_id);

        //finde the experiment
        $experiment = \App\Models\LabModule\Experiment::findOrFail(request()->experiment_id);


        if ($experiment->tests->contains($test))
            return redirect(route('experiment.show', [$experiment->id]))
                ->with([
                    'alert' => "The tests already is in the list.",
                    'class' => 'alert-warning'
                ]);


        \DB::beginTransaction();

        TestCompletion::create([
            'experiment_id' => request()->experiment_id,
            'test_id' => $test->id,
            'results' => $test->description_dr,
            'price' => $test->price,
            'currency_id' => $test->currency_id,
        ]);

        $experiment->profit->update([
            'amount' => $experiment->profit->amount + $test->price
        ]);

        \DB::commit();

        return redirect(route('experiment.show', [$experiment->id]))
            ->with([
                'alert' => "performed",
                'class' => 'alert-info'
            ]);
    }

    public function edit(TestCompletion $test_completion)
    {
        return view('lab-module.experiment.test-complition-edit', compact('test_completion'));
    }

    public function update(TestCompletion $test_completion)
    {

        $test_completion->update(request()->only(['experimentor', 'results', 'description']));

        return redirect(route('experiment.show', [$test_completion->experiment_id]))
            ->with([
                'alert' => "performed",
                'class' => 'alert-info'
            ]);
    }

    public function destroy(TestCompletion $test_completion)
    {
        //finde the experiment
        $experiment = \App\Models\LabModule\Experiment::findOrFail(request()->experiment_id);

        //find the test
        $test = \App\Models\LabModule\Test::findOrFail($test_completion->test_id);

        if (!$experiment->tests->contains($test))
            return redirect(route('experiment.show', [$experiment->id]))
                ->with([
                    'alert' => "deleted",
                    'class' => 'alert-warning'
                ]);

        \DB::beginTransaction();

        $testPrice = $test_completion->price;

        if($test_completion->delete())

            $experiment->profit->update([
                'amount' => $experiment->profit->amount - $testPrice
            ]);

        \DB::commit();

        return redirect(route('experiment.show', [$experiment->id]))
            ->with([
                'alert' => "deleted",
                'class' => 'alert-info'
            ]);
    }
}
