<?php

declare(strict_types=1);

use App\Http\Controllers\WebcamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.home');
});
Route::resources([
    'webcams' => WebcamController::class,
]);

Route::get('/quickstart', function () {
    return view('quickstart');
});
