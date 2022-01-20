<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

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

// Route::get('/', function () {
//     return view('content');
// });

Route::get('/', [MenuController::class, 'index']);

Route::resource('/', MenuController::class);

Route::get('/pdf', function () {
    $data = [
        'name'=>'test'
    ];
    $pdf = PDF::loadView('pdf', $data);
    return @$pdf->stream();
});