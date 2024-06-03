<?php

use App\Jobs\SomeJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentChartController;

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

// Route::get('/test', function () {
//     return view('welcome');
// });


// Route::get('/student-chart', [StudentChartController::class, 'index']);

Route::middleware(['auth', 'verified'])->get('/job', function () {
    SomeJob::dispatch();
});


