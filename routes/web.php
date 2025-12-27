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

Route::get('/teams/create', [Controller::class, 'createTeam'])->name('teams.create');

Route::post('/teams', [Controller::class, 'storeTeam'])->name('teams.store');

Route::get('/matches/create', [Controller::class, 'createMatch'])->name('matches.create');
Route::post('/matches', [Controller::class, 'storeMatch'])->name('matches.store');

Route::get('/login', [Controller::class, 'showLoginForm'])->name('login');
Route::post('/login', [Controller::class, 'login'])->name('login.post');

Route::get('/teams/{teamId}/follow', [Controller::class, 'followTeam'])->where('teamId','[0-9]+')->name('teams.follow');

Route::post('/', [Controller::class, 'logout'])->name('logout');

Route::get('/change-password', [Controller::class, 'showPasswordForm'])->name('change.password');