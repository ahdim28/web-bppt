<?php

use App\Http\Controllers\Admin\Catalog\CatalogCategoryController;
use App\Http\Controllers\Admin\Catalog\CatalogProductController;
use App\Http\Controllers\Admin\Catalog\CatalogProductMediaController;
use App\Http\Controllers\Admin\Catalog\CatalogTypeController;
use App\Http\Controllers\CatalogViewController;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin/catalog')->name('catalog.')
    ->group(function () {

     //type
     Route::prefix('type')->name('type.')->group(function () {

        Route::get('/', [CatalogTypeController::class, 'index'])
            ->name('index')
            ->middleware('permission:catalog_types');
        Route::get('/create', [CatalogTypeController::class, 'create'])
            ->name('create')
            ->middleware('permission:catalog_type_create');
        Route::post('/store', [CatalogTypeController::class, 'store'])
            ->name('store')
            ->middleware('permission:catalog_type_create');
        Route::get('/{id}/edit', [CatalogTypeController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:catalog_type_update');
        Route::put('/{id}', [CatalogTypeController::class, 'update'])
            ->name('update')
            ->middleware('permission:catalog_type_update');
        Route::delete('/{id}', [CatalogTypeController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:catalog_type_delete');

     });

     //category
     Route::prefix('category')->name('category.')->group(function () {

        Route::get('/', [CatalogCategoryController::class, 'index'])
            ->name('index')
            ->middleware('permission:catalog_categories');
        Route::get('/create', [CatalogCategoryController::class, 'create'])
            ->name('create')
            ->middleware('permission:catalog_category_create');
        Route::post('/store', [CatalogCategoryController::class, 'store'])
            ->name('store')
            ->middleware('permission:catalog_category_create');
        Route::get('/{id}/edit', [CatalogCategoryController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:catalog_category_update');
        Route::put('/{id}', [CatalogCategoryController::class, 'update'])
            ->name('update')
            ->middleware('permission:catalog_category_update');
        Route::put('/{id}/position/{position}', [CatalogCategoryController::class, 'position'])
            ->name('position')
            ->middleware('permission:catalog_category_update');
        Route::delete('/{id}', [CatalogCategoryController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:catalog_category_delete');

     });

      //product
      Route::prefix('product')->name('product.')->group(function () {

        Route::get('/', [CatalogProductController::class, 'index'])
            ->name('index')
            ->middleware('permission:catalog_products');
        Route::get('/create', [CatalogProductController::class, 'create'])
            ->name('create')
            ->middleware('permission:catalog_product_create');
        Route::post('/store', [CatalogProductController::class, 'store'])
            ->name('store')
            ->middleware('permission:catalog_product_create');
        Route::get('/{id}/edit', [CatalogProductController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:catalog_product_update');
        Route::put('/{id}', [CatalogProductController::class, 'update'])
            ->name('update')
            ->middleware('permission:catalog_product_update');
        Route::put('/{id}/position/{position}', [CatalogProductController::class, 'position'])
            ->name('position')
            ->middleware('permission:catalog_product_update');
        Route::put('/{id}/publish', [CatalogProductController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:catalog_product_update');
        Route::put('/{id}/selection', [CatalogProductController::class, 'selection'])
            ->name('selection')
            ->middleware('permission:catalog_product_update');
        Route::delete('/{id}', [CatalogProductController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:catalog_product_delete');

        //media
        Route::prefix('/{productId}/media')->name('media.')->
            middleware('permission:catalog_products')->group(function () {

            Route::get('/', [CatalogProductMediaController::class, 'index'])
                ->name('index');
            Route::get('/create', [CatalogProductMediaController::class, 'create'])
                ->name('create');
            Route::post('/', [CatalogProductMediaController::class, 'store'])
                ->name('store');
            Route::post('/multiple', [CatalogProductMediaController::class, 'storeMultiple'])
                ->name('store.multiple');
            Route::get('/{id}/edit', [CatalogProductMediaController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [CatalogProductMediaController::class, 'update'])
                ->name('update');
            Route::put('/{id}/position/{position}', [CatalogProductMediaController::class, 'position'])
                ->name('position');
            Route::post('/sort', [CatalogProductMediaController::class, 'sort'])
                ->name('sort');
            Route::delete('/{id}', [CatalogProductMediaController::class, 'destroy'])
                ->name('destroy');

        });

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

    Route::prefix('catalog')->name('catalog.')->group(function () {

        Route::get('/', [CatalogViewController::class, 'list'])
            ->name('view');
        //category
        Route::get('/category', [CatalogViewController::class, 'listCategory'])
            ->name('category.list');
        Route::get('/cat/{slugCategory}', [CatalogViewController::class, 'readCategory'])
            ->name('category.read');
        //product
        Route::get('/product', [CatalogViewController::class, 'listProduct'])
            ->name('product.list');
        Route::get('/{slugProduct}', [CatalogViewController::class, 'readProduct'])
            ->name('product.read');

    });
});