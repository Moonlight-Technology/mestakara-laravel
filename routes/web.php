<?php
use Illuminate\Support\Facades\Route;
use Modules\Report\Admin\StatisticController;

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
Route::get('/intro','LandingpageController@index');
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/install/check-db', 'HomeController@checkConnectDatabase');

// Social Login
Route::get('social-login/{provider}', 'Auth\LoginController@socialLogin');
Route::get('social-callback/{provider}', 'Auth\LoginController@socialCallBack');

// Logs
Route::get(config('admin.admin_route_prefix').'/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware(['auth', 'dashboard','system_log_view'])->name('admin.logs');

Route::get('/midtrans/notification', 'MidtransController@notificationHandler');
Route::post('/midtrans/notificationHandler', 'NotifController@notificationHandler');

Route::get('/install','InstallerController@redirectToRequirement')->name('LaravelInstaller::welcome');
Route::get('/install/environment','InstallerController@redirectToWizard')->name('LaravelInstaller::environment');

Route::post('/admin/module/report/statistic/reloadChart', [StatisticController::class, 'reloadChart']);

Route::get('/admin/reports/get-hotels-by-location/{location_id}', [StatisticController::class, 'getHotelsByLocation'])
    ->name('admin.reports.getHotelsByLocation');

