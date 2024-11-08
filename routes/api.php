<?php

use App\Http\Actions\PublisherAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/publishers', [PublisherAction::class, 'create']);
