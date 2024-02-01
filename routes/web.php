<?php

use App\Http\Controllers\CafeteriaPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CafeteriaPlanController::class, 'index']);
Route::post('/save', [CafeteriaPlanController::class, 'save'])->name('save');
Route::post('/xml', [CafeteriaPlanController::class, 'xml'])->name('xml');
Route::get('/get_plan_data', [CafeteriaPlanController::class, 'getPlanData']);

