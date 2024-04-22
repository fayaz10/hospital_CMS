<?php

namespace App\Http\Controllers\Receptionist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receptionist\Patient;
use Illuminate\Support\Str;

class PatientController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:rec_pat_show')->only(['index', 'show']);
        $this->middleware('permission:rec_pat_create')->only(['create', 'store']);
        $this->middleware('permission:rec_pat_edit')->only(['edit', 'update']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $patients = Patient::latest()->paginate($limit);

        return view('receptionist-module.patient.index', compact('patients'));
    }

    public function create()
    {
        return view('receptionist-module.patient.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'age' => 'required',
            'sex' => 'required',
            'phone_no' => 'required',
        ]);

        $record_no = Patient::generateRecordNo();

        $newPatient = Patient::create([
            'name' => request()->name,
            'age' => request()->age,
            'sex' => request()->sex,
            'record_no' => $record_no,
            'phone_no' => request()->phone_no,
            'address' => request()->address,
            'tazkira' => request()->tazkira,
            'registrar_id' => auth()->id(),
            'photo' => request()->hasFile('img_path') ?
                request()->img_path->move('patient_pic', request()->name . $record_no . '.' . request()->img_path->getClientOriginalExtension()) : null,
        ]);

        return redirect(route('patient.show', [$newPatient->id]))->with([
            'alert' => "created",
            'class' => 'alert-info'
        ]);
    }

    public function show(Patient $patient)
    {
        $patient->load(['prescriptions', 'experiments', 'visits']);
        return view('receptionist-module.patient.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('receptionist-module.patient.edit', compact('patient'));
    }

    public function update(Patient $patient)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'age' => 'required',
            'sex' => 'required',
            'phone_no' => 'required',
        ]);

        $patient->update(request()->except(['_token', '_method', 'img_path']));

        if (request()->hasFile('img_path'))
            $patient->update([
                'photo' => request()->img_path->move('patient_pic', request()->name . Str::uuid()->toString() . '.' . request()->img_path->getClientOriginalExtension())
            ]);

        return redirect(route('patient.show', [$patient->id]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand'
            ]);
    }

    public function filter()
    {
        if (request()->ajax()){
            if(request()->waitForApproval == "true" && request()->filled('relation')){
				
                return Patient::with([request()->relation => function ($query) {
                        $query->orderBy('created_at', 'desc');
                        $query->take(1);
                    }, request()->relation . '.approve' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                        $query->take(1);
                    }, 'surpres' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                        $query->take(1);
                    }, 'surpres.approve' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                        $query->take(1);
                    }])
                    ->where('record_no', 'like', '%' . request()->term . '%')
                    ->get()
                    ->toJson();
            }

            return Patient::where('record_no', 'like', '%' . request()->term . '%')
                ->select('id', 'name', 'record_no')
                ->get()
                ->toJson();
        }
    }

    public function search()
    {
        // return request()->term;
        if (request()->ajax())
            return Patient::search(request()->term)
                ->get();
    }

    public function invoice(Patient $patient)
    {

        // Relationships
        $visits = $patient->visits;
        $visits = $visits->sortByDesc('created_at');
        
        $doctor = optional(optional($visits)->first())->doctor;

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/invoice.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        //Personal Information
        $sheet->setCellValue('C9', $patient->name);
        $sheet->setCellValue('C10', optional($doctor)->first_name . ' ' . optional($doctor)->last_name );
        $sheet->setCellValue('C11', $patient->record_no);
        $sheet->setCellValue('C12', $patient->phone_no);
        $sheet->setCellValue('C13', $patient->age . ' years');
        $sheet->setCellValue('C14', $patient->sex == 'm' ? 'Male' : 'Female');
        $sheet->setCellValue('C15', $patient->address);

        // Services
        $rows = 20;
        foreach($visits as $visit){
            $sheet->setCellValue('A' . $rows, 'Visit');
            $sheet->setCellValue('D' . $rows, optional($visit->created_at)->format('Y/m/d'));
            $sheet->setCellValue('G' . $rows, $visit->discount);
            $sheet->setCellValue('I' . $rows, optional($visit->profit)->totalAmount);
            $rows++;
        }

        $prescriptions = $patient->prescriptions;
        $prescriptions = $prescriptions->sortByDesc('created_at');

        foreach($prescriptions as $pres){
            $sheet->setCellValue('A' . $rows, 'Prescription');
            $sheet->setCellValue('D' . $rows, optional($pres->created_at)->format('Y/m/d'));
            $sheet->setCellValue('G' . $rows, $pres->discount);
            $sheet->setCellValue('I' . $rows, optional($pres->profit)->totalAmount);
            $rows++;
        }

        $experiments = $patient->experiments;
        $experiments = $experiments->sortByDesc('created_at');

        foreach($experiments as $exper){
            $sheet->setCellValue('A' . $rows, 'LAB');
            $sheet->setCellValue('D' . $rows, optional($exper->created_at)->format('Y/m/d'));
            $sheet->setCellValue('G' . $rows, $exper->discount);
            $sheet->setCellValue('I' . $rows, optional($exper->profit)->totalAmount);
            $rows++;
        }

        $emergency = $patient->emergencies;
        $emergency = $emergency->sortByDesc('created_at');

        foreach($emergency as $emr){
            $sheet->setCellValue('A' . $rows, 'Emergency');
            $sheet->setCellValue('D' . $rows, optional($emr->created_at)->format('Y/m/d'));
            $sheet->setCellValue('G' . $rows, $emr->discount);
            $sheet->setCellValue('I' . $rows, optional($emr->profit)->totalAmount);
            $rows++;
        }

        $din = $patient->din;
        $din = $din->sortByDesc('created_at');

        foreach($din as $d){
            $sheet->setCellValue('A' . $rows, optional($d->category)->name);
            $sheet->setCellValue('D' . $rows, optional($d->created_at)->format('Y/m/d'));
            $sheet->setCellValue('G' . $rows, $d->discount);
            $sheet->setCellValue('I' . $rows, optional($d->profit)->totalAmount);
            $rows++;
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save('temp/invoice.xlsx');

        $fileName = str_replace(' ', '-', $patient->record_no . '-' . optional($patient)->name . '-printed-by-hosys');

        return response()->download('temp/invoice.xlsx', $fileName .'.xlsx');
    }
}
