<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Attachment;
use App\Models\LabModule\Experiment;

class AttachmentController extends Controller
{
    public function upload($class, $modelId)
    {
        $this->validate(request(), [
            'attachments' => 'required',
            'attachments.*' => 'required',
        ],[
            'attachments.required' => __('global.required_file'),
            'attachments.*.required' => __('global.required_file') 
        ]);

        if (method_exists($this, 'attach'. $class))
            return $this->{"attach{$class}"}($modelId);
        
        return abort(404);
    }

    public function download($class, $modelId)
    {

        $attachment = Attachment::find($modelId);

        $path = \Storage::disk('attachments')->path($attachment->path);

        return response()->download($path, $attachment->label);

    }

    public function delete($class, $modelId)
    {
        $attachment = Attachment::find($modelId);
        $attachment->delete();

        return back()->with([
            'alert' => "deleted",
            'class' => 'alert-danger'
        ]);
    }

    public function attachExperiment($id)
    {
        $instance = Experiment::find($id);
        $this->attachFile($instance, 'experiment');

        return back()->with([
            'alert' => "file_uploaded",
            'class' => 'alert-success'
        ]);
    }
    
    private function attachFile($instance, $class)
    {
        foreach (request()->attachments as $attachment) {
            $name = uniqid() . "iSys-{$class}-" . $instance->id;
            $fullPath = \Storage::disk('attachments')->putFile($name, new File($attachment));

            if (\Storage::disk('attachments')->exists($fullPath)) {

                $instance->attachments()->create([
                    'label' => $attachment->getClientOriginalName(),
                    'path' => $fullPath,
                    'mime_type' => $attachment->getClientOriginalExtension(),
                ]);
            }else
                abort(500);
        }
        

    }

}
