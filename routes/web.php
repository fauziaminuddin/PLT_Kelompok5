<?php

use Illuminate\Support\Facades\Route;
use App\Models\Config_Sympozia;

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

Route::get('/', function () {
    /*if(Config_Sympozia::where('code', 'FRP')->first()->status)
        return view('welcome');
    else
    */
        return redirect()->route('home');
    
});

Auth::routes();


Route::get('/home', \App\Http\Livewire\Arsys\Idx::class)->name('home')->middleware('cas.auth');
Route::get('/user/refresh', function () {
    \Session::flush();
    cas()->logout();
    return redirect('/');
})->name('user.refresh');

Route::get('/user/profile/create', \App\Http\Livewire\Arsys\User\Profile\Create\Idx::class)->name('arsys.user.profile.create');
Route::get('/user/profile/view', \App\Http\Livewire\Arsys\User\Profile\View\Idx::class)->name('arsys.user.profile.view');
Route::get('/user/profile/edit', \App\Http\Livewire\Arsys\User\Profile\Edit\Idx::class)->name('arsys.user.profile.edit');
Route::get('/admin/user', \App\Http\Livewire\Arsys\Admin\User\Idx::class)->name('arsys.admin.user');
Route::get('/admin/config/institution', \App\Http\Livewire\Arsys\Admin\Config\Institution\Idx::class)->name('arsys.admin.config.institution');

Route::get('/menu', \App\Http\Livewire\menu\Idx::class)->name('menu.idx');

//PLT
Route::get('/plt/landing-page', \App\Http\Livewire\Plt\Idx::class)->name('plt.home');

//schedule
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/schedule', \App\Http\Livewire\Schedule\Idx::class)->name('schedule.home');
});
