<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnounceController;
use App\Http\Controllers\CategoryRoomController;
use App\Http\Controllers\CheckVisitorController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomMemberController;
use App\Http\Controllers\UserDetailController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('refreshtoken', [AuthController::class, 'refreshToken']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('verify', [AuthController::class, 'verify']);

    //user
    Route::resource('user', AuthController::class);
    //reserve
    Route::resource('reserve', ReserveController::class);
    Route::get('getAllMyReserver/{id}', [ReserveController::class, 'getAllMyReserver']);
    //categories
    Route::resource('category', CategoryRoomController::class);
    //room
    Route::resource('room', RoomController::class);
    Route::get('findRoomAuto', [RoomController::class, 'findRoomAuto']);
    //room member
    Route::resource('roomMember', RoomMemberController::class);
    Route::get('getAllMySeat/{id}', [RoomMemberController::class, 'getAllMySeat']);
    //user detail
    Route::resource('userDetail', UserDetailController::class);
    //config
    Route::resource('config', ConfigController::class);
    //check visitor
    Route::resource('checkVisitor', CheckVisitorController::class);
    //announce
    Route::resource('announce', AnnounceController::class);
});
