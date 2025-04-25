<?php

use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/export/krs/{nim}/{semester}', [ExportController::class, 'krsPdf'])
    ->name('krs.pdf');
