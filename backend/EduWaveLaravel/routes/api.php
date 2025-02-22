<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScheduleController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('groups', GroupController::class);
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('schedules', ScheduleController::class);
});
