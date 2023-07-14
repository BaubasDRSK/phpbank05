<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController as Clnt;
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
    Route::get('/create',[Clnt::class, 'create'])->name('create');
    ROute::post('/', [Clnt::class, 'store'])->name('store');
    // Route::get('/create', [Clnt::class, 'create'])->name('create'); // GET /colors/create from URL:  colors/create Name: colors-create
    // Route::post('/', [Clnt::class, 'store'])->name('store'); // POST /colors from URL:  colors Name: colors-store
    // Route::get('/delete/{color}', [Clnt::class, 'delete'])->name('delete'); // GET /colors/delete/{color} from URL:  colors/delete/{color} Name: colors-delete
    // Route::delete('/{color}', [Clnt::class, 'destroy'])->name('destroy'); // DELETE /colors/{color} from URL:  colors/{color} Name: colors-destroy
    // Route::get('/edit/{color}', [Clnt::class, 'edit'])->name('edit'); // GET /colors/edit/{color} from URL:  colors/edit/{color} Name: colors-edit
    // Route::put('/{color}', [Clnt::class, 'update'])->name('update'); // PUT /colors/{color} from URL:  colors/{color} Name: colors-update

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('Clients list');
