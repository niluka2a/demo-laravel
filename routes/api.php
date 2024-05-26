
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

// Auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('/registration',[\App\Http\Controllers\API\Auth\AuthController::class, 'registration'])->name('registration.api');
    Route::post('/login', [\App\Http\Controllers\API\Auth\AuthController::class, 'login'])->name('login.api');
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/validate-personal-token', function () {
        return ['message' => ''];
    });
    Route::post('/auth/logout', [\App\Http\Controllers\API\Auth\AuthController::class, 'logout'])->name('logout.api');

    Route::resource('users', \App\Http\Controllers\API\UserController::class)->only('show');
    Route::resource('courses', \App\Http\Controllers\API\CourseController::class)->only('index');
});
