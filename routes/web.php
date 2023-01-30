<?php

use App\Http\Controllers\Auth\UpdatingUserController;
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

Route::post('tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [StaticPageController::class, 'dashboard'])->name('dashboard');
    Route::get('tickets/buy', [TicketController::class, 'buy'])->name('tickets.buy');
    Route::get('user/edit', [UpdatingUserController::class, 'edit'])->name('edit');
    Route::put('user/{user}/update', [UpdatingUserController::class, 'update'])->name('update');
    Route::get('events/participations', [EventController::class, 'participations'])->name('events.participations');
    Route::get('dashboard/events', [EventController::class, 'created'])->name('events.created');
});

require __DIR__.'/auth.php';
Route::resource('events', EventController::class);
