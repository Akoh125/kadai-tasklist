<?php

//use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController; // 追記

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
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// 認証済みユーザーのみアクセス可能
Route::middleware('auth')->group(function () {
    Route::resource('tasks', TasksController::class)->except(['index', 'show']);
    //Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
    //Route::get('/tasks/{task}', [TasksController::class, 'show'])->name('tasks.show');
});

require __DIR__.'/auth.php';
