<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\FixController;
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

Route::get('/register',[RegistrationController::class,'index'])->name('register');
Route::post('/register',[RegistrationController::class,'register'])->name('post.register');

Route::get('/verify',[RegistrationController::class,'verify']);
Route::post('/verify',[RegistrationController::class,'verify']);
Route::post('/key',[RegistrationController::class,'verifyKey']);

Route::get('/error',function (){
    return view('error');
})->name('error');

Route::get('/provinces/{regCode}',[AreaController::class,'getProvinces']);
Route::get('/muncity/{provCode}',[AreaController::class,'getMuncity']);
Route::get('/barangay/{citymunCode}',[AreaController::class,'getBrgy']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');

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
    Route::post('/list/fix/update',[ListController::class,'fixUpdate']);
    Route::get('/list/upload',[ListController::class,'upload'])->name('list.upload');
    Route::get('/list/delete',[ListController::class,'deleteFiles']);
    Route::get('/list/delete/{id}',[ListController::class,'deleteRecord']);
    Route::get('/list/edit/{id}',[ListController::class,'edit'])->name('list.edit');
    Route::post('/list/update/{id}',[ListController::class,'update'])->name('list.update');
    Route::get('/list/card/{id}',[ListController::class,'generateCard'])->name('list.card');

    //upload csv
    Route::post('/upload/file',[ListController::class,'uploadCSV']);
    Route::get('/export',[ListController::class,'export']);

    //fix
    Route::get('/list/fix/muncity',[FixController::class,'muncity']);
    Route::post('/list/fix/muncity',[FixController::class,'updateMuncity']);
    Route::get('/list/fix/brgy',[FixController::class,'brgy']);
    Route::post('/list/fix/brgy',[FixController::class,'updateBrgy']);

});
