<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[StaticPageController::class, 'home'])->name('home');

Route::resource('events', EventController::class);
Route::post('tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
