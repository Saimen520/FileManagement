<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::post('/upload', [FileController::class, 'upload']);
Route::get('/files', [FileController::class, 'list']);
Route::get('/download/{id}', [FileController::class, 'download']);
Route::delete('/delete/{id}', [FileController::class, 'delete']);
