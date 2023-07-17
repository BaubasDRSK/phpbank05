<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController as Clnt;
use App\Http\Controllers\AccountController as Acc;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});





Auth::routes();

Route::prefix('clients')->name('client-')->group(function () {

    Route::get('/', [Clnt::class, 'index'])->name('index');
    Route::post('/', [Clnt::class, 'index'])->name('index ');

    Route::get('/create',[Clnt::class, 'create'])->name('create');
    Route::post('/', [Clnt::class, 'store'])->name('store');

    Route::get('/edit/{client}&{page}' ,[Clnt::class, 'edit'])->name('edit');
    Route::put('/{client}&{page}', [Clnt::class, 'update'])->name('update');

    Route::get('/delete/{client}' ,[Clnt::class, 'delete'])->name('delete');
    Route::delete('/{client}', [Clnt::class, 'destroy'])->name('destroy');

    Route::get('/taxes', [Clnt::class, 'taxes'])->name('taxes');
});

Route::prefix('accounts')->name('account-')->group(function () {

    //Route::get('/', [Clnt::class, 'index'])->name('index');

    Route::get('/create/{client}&{page}',[Acc::class, 'create'])->name('create');


    Route::get('/edit/{account}&{client}' ,[Acc::class, 'edit'])->name('edit');
    Route::put('/{account}', [Acc::class, 'update'])->name('update');

    Route::get('/delete/{account}' ,[Acc::class, 'delete'])->name('delete');
    //Route::delete('/{client}', [Clnt::class, 'destroy'])->name('destroy');

    Route::get('/transfare/{account}', [Acc::class, 'select'])->name('select');
    Route::get('/transfare/{account}/{account2}', [Acc::class, 'transfare'])->name('transfare');
    Route::post('/transfare/{account}/{account2}', [Acc::class, 'execute'])->name('execute');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('Clients list');
