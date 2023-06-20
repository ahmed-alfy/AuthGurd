<?php

use App\Http\Controllers\AdminDashboard\AdminNotificationController;
use App\Http\Controllers\Auth\{
    AdminAuthController,
    ClientAuthController,
    WorkerAuthController,
};
use App\Http\Controllers\Posts\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware('api')->prefix('auth')->group(function(){

    Route::controller(AdminAuthController::class)->prefix('admin')->group(function(){
        Route::post('/login',  'login');
        Route::post('/register',  'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
        Route::get('/verify/{email:email}', 'verify')->name('verifyAdmin');

    });



    Route::controller(WorkerAuthController::class)->prefix('worker')->group(function(){
        Route::post('/login',  'login');
        Route::post('/register',  'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
        Route::get('/verify/{email:email}', 'verify')->name('verifyWorker');

    });


    Route::controller(ClientAuthController::class)->prefix('client')->group(function(){
        Route::post('/login',  'login');
        Route::post('/register',  'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
        Route::get('/verify/{email:email}', 'verify')->name('verifyClient');

    });


});

Route::controller(PostController::class)->prefix('worker')->middleware(['api'])->group(function(){
    Route::post('/add_post',  'store');
});

Route::controller(AdminNotificationController::class)->prefix('Admin/notification')->middleware(['api'])->group(function(){
    Route::get('/all',  'index');
    Route::get('/unread',  'unreadNotification');
    Route::get('/markread',  'markRead');
    Route::get('/delete/{id}',  'deleteNotification');

});
