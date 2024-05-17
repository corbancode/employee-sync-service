<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('employees/{provider}')->group(function () {
    Route::post('create', [EmployeeController::class, 'store']);
    Route::post('update', [EmployeeController::class, 'update']);
});
