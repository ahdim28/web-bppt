<?php

use App\Http\Controllers\Admin\Banner\BannerCategoryController;
use App\Http\Controllers\Admin\Banner\BannerController;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::prefix('banner/category')->name('banner.')->group(function () {

        //category
        Route::get('/', [BannerCategoryController::class, 'index'])
            ->name('category.index')
            ->middleware('permission:banner_categories');
        Route::get('/create', [BannerCategoryController::class, 'create'])
            ->name('category.create')
            ->middleware('permission:banner_category_create');
        Route::post('/store', [BannerCategoryController::class, 'store'])
            ->name('category.store')
            ->middleware('permission:banner_category_create');
        Route::get('/{id}/edit', [BannerCategoryController::class, 'edit'])
            ->name('category.edit')
            ->middleware('permission:banner_category_update');
        Route::put('/{id}', [BannerCategoryController::class, 'update'])
            ->name('category.update')
            ->middleware('permission:banner_category_update');
        Route::delete('/{id}', [BannerCategoryController::class, 'destroy'])
            ->name('category.destroy')
            ->middleware('permission:banner_category_delete');

        //banner
        Route::get('/{categoryId}', [BannerController::class, 'index'])
            ->name('index')
            ->middleware('permission:banners');
        Route::get('/{categoryId}/create', [BannerController::class, 'create'])
            ->name('create')
            ->middleware('permission:banner_create');
        Route::post('/{categoryId}', [BannerController::class, 'store'])
            ->name('store')
            ->middleware('permission:banner_create');
        Route::post('/{categoryId}/multiple', [BannerController::class, 'storeMultiple'])
            ->name('store.multiple')
            ->middleware('permission:banner_create');
        Route::get('/{categoryId}/{id}/edit', [BannerController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:banner_update');
        Route::put('/{categoryId}/{id}', [BannerController::class, 'update'])
            ->name('update')
            ->middleware('permission:banner_update');
        Route::put('/{categoryId}/{id}/publish', [BannerController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:banner_update');
        Route::put('/{categoryId}/{id}/position/{position}', [BannerController::class, 'position'])
            ->name('position')
            ->middleware('permission:banner_update');
        Route::post('/{categoryId}/sort', [BannerController::class, 'sort'])
            ->name('sort')
            ->middleware('permission:banner_update');
        Route::delete('/{categoryId}/{id}', [BannerController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:banner_delete');

    });

});