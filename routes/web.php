<?php

use Livewire\Livewire;
use App\Models\Department\Department;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\EOD\EodLivewire;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pages\Order\ImportController;
use App\Http\Controllers\Pages\WorkBase\EODController;
use App\Http\Controllers\Pages\Order\ShipmentController;
use App\Http\Controllers\Pages\Organization\AssetController;
use App\Http\Controllers\Pages\Roomease\ApartmentController;
use App\Http\Controllers\Pages\Administration\RoleController;
use App\Http\Controllers\Pages\Administration\UserController;
use App\Http\Controllers\Pages\Dashboard\DashboardController;
use App\Http\Controllers\Pages\Organization\BranchController;
use App\Http\Controllers\Pages\Organization\CustomerController;
use App\Http\Controllers\Pages\Organization\EmployeeController;
use App\Http\Controllers\Pages\Organization\DepartmentController;
use App\Http\Controllers\Pages\Administration\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('pages/dashboard/index');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware(['auth', 'verified'])->group(function () {

// Route::resource('order', DashboardController::class);

// Route::get('/', function () { return view('pages/dashboard/index'); });

Route::get('/', fn() =>  redirect(route('dashboard.index')));

// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('dashboard', DashboardController::class);
    Route::resource('administration/role', RoleController::class);
    Route::resource('administration/permission', PermissionController::class);
    Route::resource('administration/user', UserController::class);
    Route::get('administration/user-activity', [UserController::class, 'userActivity']);

    Route::resource('organization/employee', EmployeeController::class);
    Route::resource('organization/customer', CustomerController::class);
    Route::resource('assets/asset', AssetController::class);
    Route::resource('organization/branch', BranchController::class);
    Route::resource('organization/department', DepartmentController::class);

    Route::resource('roomease/apartment', ApartmentController::class);

    Route::resource('workbase/eodreport', EODController::class);
    Route::get('workbase/eodlist/{id?}', [EODController::class, 'EODList'])->name('eod.list');
});

require __DIR__ . '/auth.php';


Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/ams/livewire/update', $handle);
});
