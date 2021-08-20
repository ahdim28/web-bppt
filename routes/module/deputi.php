<?php

use App\Http\Controllers\Admin\Deputi\StructureOrganizationController;
use App\Http\Controllers\PageViewController;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin')->group(function () {

    //structure
    Route::prefix('structure')->name('structure.')->group(function () {

        Route::get('/', [StructureOrganizationController::class, 'index'])
            ->name('index')
            ->middleware('permission:structures');
        Route::get('/create', [StructureOrganizationController::class, 'create'])
            ->name('create')
            ->middleware('permission:structure_create');
        Route::post('/store', [StructureOrganizationController::class, 'store'])
            ->name('store')
            ->middleware('permission:structure_create');
        Route::get('/{id}/edit', [StructureOrganizationController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:structure_update');
        Route::put('/{id}', [StructureOrganizationController::class, 'update'])
            ->name('update')
            ->middleware('permission:structure_update');
        Route::put('/{id}/position/{position}', [StructureOrganizationController::class, 'position'])
            ->name('position')
            ->middleware('permission:structure_update');
        Route::delete('/{id}', [StructureOrganizationController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:structure_delete');
            
    });

});

/**
 * frontend
 */

$group = ['middleware' => ['language']];

if (config('custom.language.needLocale')) {
    $group['prefix'] = '{locale?}';
}

Route::group($group, function () {

    Route::get('/organisasi', [PageViewController::class, 'listStructure'])
        ->name('structure.list');
    Route::get('/organisasi/{slugStructure}', [PageViewController::class, 'readStructure'])
        ->name('structure.read');

});