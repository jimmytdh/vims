<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\FixController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\VasController;
use App\Http\Controllers\VaccinatorController;
use App\Http\Controllers\QuickCountController;
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
Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'validateLogin'])->name('validate.login');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('/verify',[RegistrationController::class,'verify']);
Route::post('/verify',[RegistrationController::class,'verify']);
Route::post('/key',[RegistrationController::class,'verifyKey']);

Route::get('/error',function (){
    return view('errors.503');
})->name('error');

Route::get('/provinces/{regCode}',[AreaController::class,'getProvinces']);
Route::get('/muncity/{provCode}',[AreaController::class,'getMuncity']);
Route::get('/barangay/{citymunCode}',[AreaController::class,'getBrgy']);

//Registration
Route::get('/register',[RegistrationController::class,'index'])->name('register');
Route::post('/register',[RegistrationController::class,'register'])->name('post.register');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/chart', [HomeController::class, 'chart'])->name('chart');

    Route::group(['middleware' => 'admin'],function() {
        Route::get('/mydata', [HomeController::class, 'myData']);
        Route::post('/mydata', [HomeController::class, 'myData']);

        //update x-editable
        Route::post('/mydata/update/user', [HomeController::class, 'userUpdate']);
        Route::post('/mydata/update/personal', [HomeController::class, 'personalUpdate']);
        Route::post('/mydata/update/data', [HomeController::class, 'dataUpdate']);
        Route::post('/mydata/update/comorbidity', [HomeController::class, 'dataComorbidity']);
        Route::post('/mydata/update/table/{table}', [HomeController::class, 'tableUpdate']);

        //manage list
        Route::get('/list/master',[ListController::class,'index']);
        Route::get('/list/data',[ListController::class,'data'])->name('list.data');
        Route::get('/list/fix',[ListController::class,'fix'])->name('list.fix');

        Route::get('/list/upload',[ListController::class,'upload'])->name('list.upload');
        Route::get('/list/delete',[ListController::class,'deleteFiles']);
        Route::get('/list/delete/{id}',[ListController::class,'deleteRecord']);
        Route::get('/list/edit/{id}',[ListController::class,'edit'])->name('list.edit');
        Route::post('/list/update/{id}',[ListController::class,'update'])->name('list.update');

        //upload csv
        Route::post('/upload/file',[ListController::class,'uploadCSV']);
        Route::post('/upload/compare',[ListController::class,'compareCSV']);
        Route::get('/export',[ListController::class,'export']);
        Route::get('/export/lacking',[ListController::class,'exportLacking']);

        //fix
        Route::get('/list/fix/muncity',[FixController::class,'muncity']);
        Route::post('/list/fix/muncity',[FixController::class,'updateMuncity']);
        Route::get('/list/fix/brgy',[FixController::class,'brgy']);
        Route::post('/list/fix/brgy',[FixController::class,'updateBrgy']);
    });

    Route::post('/list/fix/update',[ListController::class,'fixUpdate']);

    Route::get('/list',[LimitController::class,'showList']);
    Route::get('/export/confirmed',[LimitController::class,'exportList']);
    Route::get('/export/1stDosage',[VaccineController::class,'exportDosage1']);
    Route::get('/export/2ndDosage',[VaccineController::class,'exportDosage2']);

    Route::get('/list/card/all/{offset}/{limit}',[ListController::class,'generateAllCard']);
    Route::get('/list/card/{id}',[ListController::class,'generateCard'])->name('list.card');


    //Employees
    Route::get('/employees',[EmployeeController::class,'index'])->name('list.employee');
    Route::post('/employees/search',[EmployeeController::class,'search']);
    Route::post('/employees/update',[EmployeeController::class,'update']);
    Route::get('/employees/import',[EmployeeController::class,'importUser']);

    Route::post('/vaccine/',[VaccineController::class,'update']);
    Route::get('/vaccine/',[VaccineController::class,'show']);
    Route::post('/vaccine/list',[VaccineController::class,'updateGroupList']);
    Route::post('/vaccine/transfer',[VaccineController::class,'transfer']);
    Route::post('/vaccine/schedule/',[VaccineController::class,'updateSchedule']);
    Route::post('/vaccine/update/list',[VaccineController::class,'fixUpdate'])->name('vaccine.update.list');
    Route::get('/vaccine/{id}',[VaccineController::class,'show']);





//    Route::get('/fix/users',[RegistrationController::class,'updateUsers']);

    //mange VAS
    Route::get('/list/vas',[VasController::class,'index'])->name('vas.list');
    Route::get('/list/vas/all',[VasController::class,'allData'])->name('vas.all');
    Route::get('/list/vas/edit/{id}',[VasController::class,'edit']);
    Route::get('/list/vas/delete/{id}',[VasController::class,'delete']);
    Route::post('/list/vas/date',[VasController::class,'changeDate']);
    Route::post('/list/vas/status',[VasController::class,'changeStatus']);
    Route::post('/list/vas/update/{id}',[VasController::class,'update']);
    Route::get('/register/vas',[VasController::class,'register'])->name('vas.register');
    Route::post('/register/vas',[VasController::class,'saveRegistration'])->name('vas.save.register');

    Route::get('/vas/vaccination/{id}',[VasController::class,'vaccination']);
    Route::post('/vas/vaccination/{id}',[VasController::class,'saveVaccination']);
    Route::get('/vas/health/{id}',[VasController::class,'healthCondition']);
    Route::post('/vas/health/{id}',[VasController::class,'saveHealthCondition']);

    Route::get('/vas/vaccinator',[VaccinatorController::class,'index']);
    Route::post('/vas/vaccinator/save',[VaccinatorController::class,'store'])->name('add.vaccinator');
    Route::post('/vas/vaccinator/update',[VaccinatorController::class,'update'])->name('update.vaccinator');
    Route::post('/vas/vaccinator/destroy',[VaccinatorController::class,'destroy'])->name('destroy.vaccinator');

    Route::get('/export/vas',[VasController::class,'exportData']);
    Route::post('/vas/schedule',[VasController::class,'schedule']);
    Route::get('/vas/schedule/delete/{id}',[VasController::class,'deleteVaccination']);
    Route::post('/vas/editable',[VasController::class,'editable']);
    Route::post('/vas/upload',[VasController::class,'uploadList']);

    //CBCR Reporting
    Route::get('/cbcr',[QuickCountController::class,'index']);
    Route::post('/cbcr/date',[QuickCountController::class,'changeDate']);
    Route::post('/cbcr/update',[QuickCountController::class,'update']);

});
