<?php

use App\Http\Controllers\Admin\ConfigurationController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\Menu\MenuCategoryController;
use App\Http\Controllers\Admin\Menu\MenuController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {

    //extra
    Route::get('/visitor', [ConfigurationController::class, 'visitor'])
        ->name('visitor')
        ->middleware('permission:visitor');
    Route::get('/filemanager', [ConfigurationController::class, 'filemanager'])
        ->name('filemanager')
        ->middleware('permission:filemanager');
    Route::get('/backup', [ConfigurationController::class, 'backup'])
        ->name('backup')
        ->middleware('permission:backup');
    Route::get('/backup/{id}/download', [ConfigurationController::class, 'backupDownload'])
        ->name('backup.download')
        ->middleware('permission:backup');

    //configurations
    Route::get('/configuration/website', [ConfigurationController::class, 'website'])
        ->name('configuration.website')
        ->middleware('permission:configurations');
    Route::put('/configuration/website', [ConfigurationController::class, 'update'])
        ->name('configuration.website.update')
        ->middleware('permission:configurations');
    Route::put('/configuration/website/{name}/upload', [ConfigurationController::class, 'upload'])
        ->name('configuration.website.upload')
        ->middleware('permission:configurations');
    Route::get('/configuration/common/{lang}', [ConfigurationController::class, 'common'])
        ->name('configuration.common')
        ->middleware('permission:commons');
    Route::get('/maintenance', [ConfigurationController::class, 'maintenance'])
        ->name('maintenance')
        ->middleware('role:super');

    //menu
    Route::prefix('menu')->name('menu.')->group(function () {

        Route::get('/category', [MenuCategoryController::class, 'index'])
            ->name('category.index')
            ->middleware('permission:menu_categories');
        Route::post('/category/store', [MenuCategoryController::class, 'store'])
            ->name('category.store')
            ->middleware('permission:menu_category_create');
        Route::put('/category/{id}', [MenuCategoryController::class, 'update'])
            ->name('category.update')
            ->middleware('permission:menu_category_update');
        Route::delete('/category/{id}', [MenuCategoryController::class, 'destroy'])
            ->name('category.destroy')
            ->middleware('permission:menu_category_delete');

        Route::get('/category/{categoryId}', [MenuController::class, 'index'])
            ->name('index')
            ->middleware('permission:menus');
        Route::get('/category/{categoryId}/create', [MenuController::class, 'create'])
            ->name('create')
            ->middleware('permission:menu_create');
        Route::post('/category/{categoryId}/store', [MenuController::class, 'store'])
            ->name('store')
            ->middleware('permission:menu_create');
        Route::get('/category/{categoryId}/{id}/edit', [MenuController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:menu_update');
        Route::put('/category/{categoryId}/{id}', [MenuController::class, 'update'])
            ->name('update')
            ->middleware('permission:menu_update');
        Route::put('/category/{categoryId}/{id}/publish', [MenuController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:menu_update');
        Route::put('/category/{categoryId}/{id}/position/{position}', [MenuController::class, 'position'])
            ->name('position')
            ->middleware('permission:menu_update');
        Route::delete('/category/{categoryId}/{id}', [MenuController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:menu_delete');

    });
    
    //language
    Route::prefix('language')->name('language.')->middleware('role:super')->group(function () {

            Route::get('/', [LanguageController::class, 'index'])
                ->name('index');
            Route::get('/trash', [LanguageController::class, 'trash'])
                ->name('trash');
            Route::get('/create', [LanguageController::class, 'create'])
                ->name('create');
            Route::post('/store', [LanguageController::class, 'store'])
                ->name('store');
            Route::get('/{id}/edit', [LanguageController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [LanguageController::class, 'update'])
                ->name('update');
            Route::put('/{id}/status', [LanguageController::class, 'status'])
                ->name('status');
            Route::delete('/{id}/soft', [LanguageController::class, 'softdelete'])
                ->name('soft');
            Route::delete('/{id}/permanent', [LanguageController::class, 'permanentDelete'])
                ->name('permanent');
            Route::put('/{id}/restore', [LanguageController::class, 'restore'])
                ->name('restore');

    });

});