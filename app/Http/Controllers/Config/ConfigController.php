<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the limits for pagination
        $configs = config('iSys');
        // dd(config('iSys'));
        return view('config.index', compact('configs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('config.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|min:2',
            'value' => 'required',
        ]);
        
        $value = $request->value;
        // $fp = fopen(base_path() .'/config/iSys.php' , 'a');
        // fwrite($fp, "{$request->key} => {$request->value}");
        // fclose($fp);
        $lines = file(base_path() .'/config/iSys.php', FILE_IGNORE_NEW_LINES); 
        $last = sizeof($lines) - 2 ; 

        if ($value == 'true' || $value == 'false')
            $value = settype($value, 'boolean');
        // dd(is_bool($value));
                // 'value' => settype($request->value, 'boolean'),
                // if (in_array(gettype($request->value), ['boolean', 'integer', 'double', 'float', 'array'])){
        if (is_numeric($value) || is_array($value) || is_bool($value)){
            $lines[$last] .= ",\n\t'{$request->key}' => {$value}\n";
            file_put_contents( base_path() .'/config/iSys.php', implode( "\n", $lines ) );
        }
        
        else {
            $lines[$last] .= ",\n\t'{$request->key}' => '{$value}'\n";
            file_put_contents( base_path() .'/config/iSys.php', implode( "\n", $lines ) );
        }
        // load the data and delete the line from the array 


        return redirect('/admin/config');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show($config, $subConfig = null)
    {
        $subConfig = $subConfig ? '.' . str_replace('/', '.', $subConfig) : null;
        
        $config = config("iSys.{$config}{$subConfig}");
        if (!$config)
            abort(404);
        dd($config);
        return view('course-module.course.show', compact('config'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit($configKey)
    {
        $config = config("iSys.{$configKey}");
        return view('config.edit', compact('config', 'configKey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Course\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update($config)
    {
        $this->validate(request(), [
            'key' => 'required|min:2',
            'value' => 'required',
        ]);
        
        $value = request()->value;

        $lines = file(base_path() .'/config/iSys.php', FILE_IGNORE_NEW_LINES); 

        dd($lines);

        dd(array_search("'".$config."'", $lines, true));

        $last = sizeof($lines) - 2 ; 

        return redirect(route('course.show', $course->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function showAdmission(Course $course)
    {
        return view('course-module.course.admission', compact('course'));
    }
}
