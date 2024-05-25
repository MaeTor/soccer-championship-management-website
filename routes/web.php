<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [Controller::class, 'showRanking'])->name('ranking.show');

Route::get('/teams/{teamId}', [Controller::class, 'showTeam'])->where('teamId', '[0-9]+')->name('teams.show');
