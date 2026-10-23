<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DeputyController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\EmployeeTrainingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\RecommendationTypeController;
use App\Http\Controllers\TrainingRecommendationController;
use App\Http\Controllers\UserManagementController;

Route::get('/', fn () => view('auth.login'))->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.attempt');

//user
Route::group(['middleware' => ['auth', 'check_role:user']], function(){
    Route::get('/user/dashboard', [UserController::class, 'dashboard']);
    Route::get('/user/divisi/{id_pegawai}', [UserController::class, 'showEmployeeDetail']);
    Route::get('/user/division/{id_divisi}', [UserController::class, 'showDivision'])->name('division.show');
    
    // Employee routes
    Route::get('/user/card/{id_pegawai}', [UserController::class, 'showEmployeeDetail'])->name('employee.card');
    Route::get('/user/employees/{id}', [UserController::class, 'showEmployeeDetail'])->name('employee');
    Route::get('/recommendations/{id}', [UserController::class, 'getRecommendations']);
    
    // Other routes
    Route::get('/user/strukturorganisasi', [UserController::class, 'showAllDeputies'])->name('user.strukturorganisasi');
    Route::get('/category/{id_kategori}/details', [UserController::class, 'getCategoryDetails'])->name('category.details');
    Route::get('/user/deputi/{id_deputi}', [UserController::class, 'showDeputy'])->name('deputi.show');
    Route::get('/user/search', [UserController::class, 'search'])->name('search');
});

//admin
Route::group(['middleware' => ['auth', 'check_role:admin']], function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/daftarpegawai', [AdminController::class, 'daftarPegawai'])->name('admin.daftarpegawai');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::delete('/employees/destroy/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');

    Route::resource('deputies', DeputyController::class)
    ->parameters(['deputies' => 'id'])
    ->names('admin.deputies')
    ->except(['create', 'edit', 'show']);
 
    Route::resource('divisions', DivisionController::class)
    ->parameters(['divisions' => 'id'])
    ->names('admin.divisions')
    ->except(['create', 'edit', 'show']);

    Route::resource('trainings', TrainingController::class)
    ->parameters(['trainings' => 'id'])
    ->names('admin.trainings')
    ->except(['create', 'edit', 'show']);
 
Route::get('employee-trainings', [EmployeeTrainingController::class, 'index'])
    ->name('admin.employee-trainings.index');
Route::post('employee-trainings', [EmployeeTrainingController::class, 'store'])
    ->name('admin.employee-trainings.store');
Route::put('employee-trainings/{id_pegawai}/{id_pelatihan}', [EmployeeTrainingController::class, 'update'])
    ->name('admin.employee-trainings.update');
Route::delete('employee-trainings/{id_pegawai}/{id_pelatihan}', [EmployeeTrainingController::class, 'destroy'])
    ->name('admin.employee-trainings.destroy');
    Route::resource('categories', CategoryController::class)
    ->parameters(['categories' => 'id'])
    ->names('admin.categories')
    ->except(['create', 'edit', 'show']);
 
Route::resource('subcategories', SubcategoryController::class)
    ->parameters(['subcategories' => 'id'])
    ->names('admin.subcategories')
    ->except(['create', 'edit', 'show']);
    Route::resource('recommendation-types', RecommendationTypeController::class)
    ->parameters(['recommendation-types' => 'id'])
    ->names('admin.recommendation-types')
    ->except(['create', 'edit', 'show']);
 
Route::resource('training-recommendations', TrainingRecommendationController::class)
    ->parameters(['training-recommendations' => 'id'])
    ->names('admin.training-recommendations')
    ->except(['create', 'edit', 'show']);
    Route::resource('users', UserManagementController::class)
    ->parameters(['users' => 'id'])
    ->names('admin.users')
    ->except(['create', 'edit', 'show']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
