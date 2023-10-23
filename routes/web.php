<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsulController;
use App\Http\Controllers\UndiUsulController;
use App\Http\Controllers\PilihUsulController;
use Illuminate\Support\Facades\Auth;
  
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

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('optimize');
    dd("Success..! OK");
});

/*Route::get('/', function () {
    return redirect('login');
});*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('sijil', function () {
    return view('pages/sijil');
});

Auth::routes();
  
/*------------------------------------------
--------------------------------------------
President Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:president'])->group(function () {
  
    Route::get('ikebs/dashboard', [HomeController::class, 'ikebs_dashboard'])->name('ikebs-dashboard');
    Route::get('ikebs/senarai-usul', [UsulController::class, 'ikebs_senarai_usul'])->name('ikebs-senarai-usul');
    Route::post('ikebs/store-usul', [UsulController::class, 'ikebs_store_usul'])->name('store-usul');
    Route::post('ikebs/edit-usul', [UsulController::class, 'ikebs_edit_usul']);
    Route::post('ikebs/update-usul', [UsulController::class, 'ikebs_update_usul']);
    Route::get('ikebs/keputusan-undi', [UndiUsulController::class, 'ikebs_keputusan_usul'])->name('ikebs-keputusan-usul');
    
});

/*------------------------------------------
--------------------------------------------
Bendahari Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:bendahari'])->group(function () {
  
    Route::get('adbs/dashboard', [HomeController::class, 'adbs_dashboard'])->name('adbs.dashboard');
    Route::get('adbs/pilih-usul', [PilihUsulController::class, 'adbs_senarai_pilih_usul'])->name('adbs-senarai-pilih-usul');
    Route::post('adbs/store-pilih-usul', [PilihUsulController::class, 'adbs_store_pilih_usul'])->name('adbs-store-pilih-usul');

    Route::get('adbs/undi', [UndiUsulController::class, 'adbs_senarai_usul'])->name('adbs-undi');
    Route::post('adbs/undi-usul', [UndiUsulController::class, 'adbs_undi_usul']);
    Route::post('adbs/store-undi-usul', [UndiUsulController::class, 'adbs_store_undi'])->name('adbs-store-undi');
    Route::get('adbs/profil', [HomeController::class, 'adbs_profil'])->name('adbs-profil');
    Route::post('adbs/update-password', [HomeController::class, 'adbs_update_password'])->name('adbs-update-password');

});

