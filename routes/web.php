<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('tasks.index');
});

Route::get('tasks/{task}/delete-confirm', [TaskController::class, 'confirmDelete'])->name('tasks.delete-confirm');
Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

Route::resource('tasks', TaskController::class)->except(['show', 'create']);

Route::post('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
