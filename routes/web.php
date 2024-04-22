<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main url route
Route::get('/', function () {
    return redirect()->route('login');
});

// Login Routes
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

// Language Changes
Route::get('/lang/{lang}', function ($lang) {

    \Request::session()->put('lang', $lang);
    return redirect()->back();
})->name('lang');


// User Profile
Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {
    Route::get('/{user}', 'Profile\ProfileController@index')->name('profile');
    Route::post('/{user}', 'Profile\ProfileController@changePassword')->name('profile.change');
    Route::put('/{user}', 'Profile\ProfileController@update')->name('profile.update');
});

// Test route
Route::get('/test', function () {
});

// System Administration
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'HasModuleAccess']], function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::get('/', 'SystemAdmin\HomeController@index');

    Route::get('/module', 'SystemAdmin\ModuleController@index');
    Route::post('/module/assign', 'SystemAdmin\ModuleController@assign');
    Route::get('/module/create', 'SystemAdmin\ModuleController@create');
    Route::post('/module', 'SystemAdmin\ModuleController@store');
    Route::get('/module/{module}', 'SystemAdmin\ModuleController@show');
    Route::get('/module/{module}/edit', 'SystemAdmin\ModuleController@edit');
    Route::put('/module/{module}', 'SystemAdmin\ModuleController@update');

    // Route of Roles
    Route::get('/role', 'SystemAdmin\RoleController@index');
    Route::post('/role/assign', 'SystemAdmin\RoleController@assign');
    Route::get('/role/create', 'SystemAdmin\RoleController@create');
    Route::post('/role/perm/create', 'SystemAdmin\RoleController@createPerm');
    Route::post('/role/perm/assign', 'SystemAdmin\RoleController@assignPerms');
    Route::post('/role', 'SystemAdmin\RoleController@store');
    Route::get('/role/{role}', 'SystemAdmin\RoleController@show');
    Route::get('/role/{role}/edit', 'SystemAdmin\RoleController@edit');
    Route::put('/role/{role}', 'SystemAdmin\RoleController@update');

    // Route of Users

    Route::get('/user', 'SystemAdmin\UserController@index');
    Route::get('/user/search', 'SystemAdmin\UserController@search')->name('user.search');
    Route::get('/user/create', 'SystemAdmin\UserController@create');
    Route::get('/user/status/{user}', 'SystemAdmin\UserController@changeStatus');
    Route::post('/user', 'SystemAdmin\UserController@store');
    Route::get('/user/{user}', 'SystemAdmin\UserController@show')->name('user.show');
    Route::get('/user/{user}/edit', 'SystemAdmin\UserController@edit');
    Route::post('/user/{user}/reset', 'SystemAdmin\UserController@reset');
    Route::put('/user/{user}', 'SystemAdmin\UserController@update');
    Route::delete('/user/{user}', 'SystemAdmin\UserController@destroy');

    // Config route
    Route::get('/config', 'Config\ConfigController@index');
    Route::get('/config/create', 'Config\ConfigController@create');
    Route::post('/config', 'Config\ConfigController@store');

    Route::get('/config/{config}/edit', 'Config\ConfigController@edit');
    Route::get('/config/{config}/{subConfig?}', 'Config\ConfigController@show')
        ->where('subConfig', '(.*)');

    Route::put('/config/{config}', 'Config\ConfigController@update');
});


//Student Module Routes
Route::group(['namespace' => 'Student', 'prefix' => 'student', 'middleware' => ['auth', 'HasModuleAccess']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('student.home');
    Route::get('student/json/{option?}', 'StudentController@json')->name('student.json');
    Route::resource('/student', 'StudentController');
    Route::resource('/transcript', 'TranscriptController');
    Route::resource('/timesheet', 'TimeSheetController');
});
//END Student Module Routes

//Subject and Course Module Routes
Route::group(['namespace' => 'Course', 'prefix' => 'course', 'middleware' => ['auth', 'HasModuleAccess']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('course.home');
    Route::get('/admission/{course}', 'CourseController@showAdmission')->name('admission.add');
    Route::post('/admission/{course}', 'CourseController@storeAdmission')->name('admission.store');
    Route::resource('/course', 'CourseController');
    Route::resource('/subject', 'SubjectController');
});
//END Subject and Course Module Routes

//START Finance Module
Route::group(['prefix' => 'finance', 'middleware' => ['auth', 'HasModuleAccess']], function () {

    // Home Controller
    Route::get('/in-ex-graph', 'FinanceModule\HomeController@inExGraph')->name('finance.in-ex-graph');
    Route::get('/income-graph', 'FinanceModule\HomeController@incomeGraph')->name('finance.income-graph');
    Route::get('/', 'FinanceModule\HomeController@index');

    //income list
    Route::get('/income/filter', 'FinanceModule\IncomeController@filter')->name('income.filter');

    Route::resource('/income', 'FinanceModule\IncomeController')
    ->except(['create', 'store', 'update', 'destroy', 'edit']);

    Route::get('/expense/filter', 'FinanceModule\ExpenseController@filter')->name('expense.filter');

    Route::resource('/expense', 'FinanceModule\ExpenseController')
    ->except(['create', 'store', 'update', 'destroy', 'edit']);

    // Route::get('/expense/filter', 'FinanceModule\ExpenseController@filter')->name('expense.filter');

    Route::get('/diverse-income/filter', 'FinanceModule\DiverseIncomeController@filter')->name('diverse-income.filter');
    Route::get('/diverse-income/search', 'FinanceModule\DiverseIncomeController@search')->name('diverse-income.search');
    Route::resource('/diverse-income', 'FinanceModule\DiverseIncomeController');

    Route::get('/diverse-expense/filter', 'FinanceModule\DiverseExpenseController@filter')->name('diverse-expense.filter');
    Route::get('/diverse-expense/search', 'FinanceModule\DiverseExpenseController@search')->name('diverse-expense.search');
    Route::resource('/diverse-expense', 'FinanceModule\DiverseExpenseController');
});

//Receptionist Module Routes
Route::group(['prefix' => 'receptionist', 'middleware' => ['auth', 'HasModuleAccess']], function () {

    Route::get('/', 'Receptionist\ReceptionistController@dashboard')->name('receptionist.dashboard');
    
    Route::get('/reports', 'Receptionist\ReceptionistController@index')->name('reports.index');
    Route::get('/reports/daily', 'Receptionist\ReceptionistController@daily')->name('reports.daily');
    Route::get('/visit-graph', 'Receptionist\ReceptionistController@visitGraph')->name('receptionis.visit-graph');

    // Doctors
    Route::get('/doctor/filter', 'Receptionist\DoctorController@filter')->name('doctor.filter');
    Route::get('/doctor/inc-balance', 'Receptionist\DoctorController@incomeBalance')->name('doctor.balance');
    Route::get('/doctor/search', 'Receptionist\DoctorController@search')->name('doctor.search');
    Route::resource('doctor', 'Receptionist\DoctorController');

    // Patient
    Route::get('/patient/search', 'Receptionist\PatientController@search')->name('patient.search');
    Route::get('/patient/filter', 'Receptionist\PatientController@filter')->name('patient.filter');
    Route::get('/patient/invoice/{patient}', 'Receptionist\PatientController@invoice')->name('patient.invoice');
    Route::resource('patient', 'Receptionist\PatientController');

    // Visit
    Route::get('/visit/search', 'Receptionist\VisitController@search')->name('visit.search');
    Route::get('/visit/print/{visit}', 'Receptionist\VisitController@print')->name('visit.print');
    Route::resource('visit', 'Receptionist\VisitController');
    
    // Approval
    Route::get('/approval/search', 'ApprovableController@search')->name('approval.search');
    Route::post('/approval/approve/{approval}', 'ApprovableController@approve')->name('approval.approve');
    Route::delete('/approval/reject/{approval}', 'ApprovableController@reject')->name('approval.reject');
    Route::resource('approval', 'ApprovableController')->except(['create', 'edit', 'store', 'destroy', 'update']);
    
    // Emergency
    Route::get('/emergency/filter', 'Receptionist\EmergencyController@filter')->name('emergency.filter');
    Route::get('/emergency/print/{emergency}', 'Receptionist\EmergencyController@print')->name('emergency.print');
    Route::resource('emergency', 'Receptionist\EmergencyController');

    // Diver Income
    Route::get('/din/filter', 'Receptionist\DiverseIncomeController@filter')->name('din.filter');
    Route::get('/din/search', 'Receptionist\DiverseIncomeController@search')->name('din.search');
    Route::get('/din/print/{din}', 'Receptionist\DiverseIncomeController@print')->name('din.print');
    Route::resource('/din', 'Receptionist\DiverseIncomeController');
});
//END Subject and Course Module Routes


//Laboratory Module Routes
Route::group(['prefix' => 'lab', 'middleware' => ['auth', 'HasModuleAccess']], function () {
    Route::get('/', 'LabModule\LabController@index')->name('lab.dashboard');

    Route::resource('/test-completion', 'LabModule\TestCompletionController')
        ->except(['index', 'create']);

    Route::get('/test/search', 'LabModule\TestController@search')->name('test.search');
    Route::resource('/test', 'LabModule\TestController');

    Route::get('/sub-test/search', 'LabModule\SubTestController@search')->name('sub-test.search');
    Route::resource('/sub-test', 'LabModule\SubTestController');

    Route::get('/experiment/filter', 'LabModule\ExperimentController@filter')->name('experiment.filter');
    Route::get('/experiment/search', 'LabModule\ExperimentController@search')->name('experiment.search');
    Route::get('/experiment/print/{experiment}', 'LabModule\ExperimentController@print')->name('experiment.print');
    Route::get('/experiment/form/{experiment}', 'LabModule\ExperimentController@form')->name('experiment.form');
    Route::get('/experiment/refund/{experiment}', 'LabModule\ExperimentController@refund')->name('experiment.refund');
    Route::get('/experiment/filter/ajax', 'LabModule\ExperimentController@ajaxFilter')->name('experiment.filter.ajax');
    Route::resource('/experiment', 'LabModule\ExperimentController');
});
//END Laboratory Module Routes

//Pharmacist Module Routes
Route::group(['prefix' => 'pharmacist', 'middleware' => ['auth', 'HasModuleAccess']], function () {

    Route::get('/medicine/filter/ajax', 'Pharmacist\MedicineController@ajaxFilter')->name('medicine.filter.ajax');
    Route::get('/medicine/search', 'Pharmacist\MedicineController@search')->name('medicine.search');
    Route::get('/medicine/filter', 'Pharmacist\MedicineController@filter')->name('medicine.filter');
    Route::get('/medicine/edit-multiple', 'Pharmacist\MedicineController@editMultiple')->name('medicine.edit-multipe');
    Route::post('/medicine/assign-multiple', 'Pharmacist\MedicineController@assignMultiple')->name('medicine.assign-multipe');
    Route::resource('medicine', 'Pharmacist\MedicineController');

    Route::get('/medicine-purchase/filter', 'Pharmacist\MedicinePurchaseController@filter')->name('medicine-purchase.filter');
    Route::resource('medicine-purchase', 'Pharmacist\MedicinePurchaseController');

    Route::resource('purchase-list', 'Pharmacist\PurchaseListController')
        ->except(['create', 'edit']);

    Route::resource('stock-out', 'Pharmacist\MedicineStockOutController')
        ->except(['create', 'index', 'edit']);

    Route::get('/prescription/filter', 'Pharmacist\PrescriptionController@filter')->name('prescription.filter');
    Route::get('/prescription/print/{prescription}', 'Pharmacist\PrescriptionController@print')->name('prescription.print');
    Route::get('/prescription/refund/{prescription}', 'Pharmacist\PrescriptionController@refund')->name('prescription.refund');
    Route::resource('prescription', 'Pharmacist\PrescriptionController');
    
    Route::get('/surpres/filter', 'Pharmacist\SurgeryPrescriptionController@filter')->name('surpres.filter');
    Route::get('/surpres/approve/{surpre}', 'Pharmacist\SurgeryPrescriptionController@sent2Approve')->name('surpres.sent2Approve');
    Route::get('/surpres/print/{surpre}', 'Pharmacist\SurgeryPrescriptionController@print')->name('surpres.print');
    Route::get('/surpres/refund/{surpre}', 'Pharmacist\SurgeryPrescriptionController@refund')->name('surpres.refund');
    Route::resource('surpres', 'Pharmacist\SurgeryPrescriptionController');

    Route::get('/', 'Pharmacist\PharmacistController@dashboard')->name('pharmacist.dashboard');
});
//END Pharmacist Module Routes

Route::group(['prefix' => 'attachment', 'middleware' => ['auth']], function () {
    Route::get('/{model_class}/{model_id}', 'AttachmentController@download')->name('attachment.download');
    Route::post('/{model_class}/{model_id}', 'AttachmentController@upload')->name('attachment.upload');
    Route::delete('/{model_class}/{model_id}', 'AttachmentController@delete')->name('attachment.delete');
});

Route::group(['prefix' => 'printing', 'middleware' => ['auth']], function () {
    Route::get('/prescription/{prescription}', 'Pharmacist\PrescriptionController@print')->name('rec.pres.print');
    Route::get('/experiment/{experiment}', 'LabModule\ExperimentController@print')->name('rec.expr.print');
    Route::get('/surpres/{surpre}', 'Pharmacist\SurgeryPrescriptionController@print')->name('rec.surpre.print');
});

