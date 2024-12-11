<?php

use App\Http\Controllers\Pages\Development\DevController;
use Illuminate\Support\Facades\Route;



Route::get('development/permissions', [DevController::class, 'permissions']);
