<?php

use App\Http\Controllers\Admin\Document\DocumentCategoryController;
use App\Http\Controllers\Admin\Document\DocumentController;
use App\Http\Controllers\DocumentViewController;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::prefix('document')->name('document.')->group(function () {

        //category
        Route::get('/category', [DocumentCategoryController::class, 'index'])
            ->name('category.index')
            ->middleware('permission:document_categories');
        Route::get('/category/create', [DocumentCategoryController::class, 'create'])
            ->name('category.create')
            ->middleware('permission:document_category_create');
        Route::post('/category/store', [DocumentCategoryController::class, 'store'])
            ->name('category.store')
            ->middleware('permission:document_category_create');
        Route::get('/category/{id}/edit', [DocumentCategoryController::class, 'edit'])
            ->name('category.edit')
            ->middleware('permission:document_category_update');
        Route::put('/category/{id}', [DocumentCategoryController::class, 'update'])
            ->name('category.update')
            ->middleware('permission:document_category_update');
        Route::put('/category/{id}/position/{position}', [DocumentCategoryController::class, 'position'])
            ->name('category.position')
            ->middleware('permission:document_category_update');
        Route::put('/category/{id}/publish', [DocumentCategoryController::class, 'publish'])
            ->name('category.publish')
            ->middleware('permission:document_category_update');
        Route::delete('/category/{id}', [DocumentCategoryController::class, 'destroy'])
            ->name('category.destroy')
            ->middleware('permission:document_category_delete');

        //document
        Route::get('/{categoryId}', [DocumentController::class, 'index'])
            ->name('index')
            ->middleware('permission:documents');
        Route::get('/{categoryId}/create', [DocumentController::class, 'create'])
            ->name('create')
            ->middleware('permission:document_create');
        Route::post('/{categoryId}/store', [DocumentController::class, 'store'])
            ->name('store')
            ->middleware('permission:document_create');
        Route::get('/{categoryId}/{id}/edit', [DocumentController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:document_update');
        Route::put('/{categoryId}/{id}', [DocumentController::class, 'update'])
            ->name('update')
            ->middleware('permission:document_update');
        Route::put('/{categoryId}/{id}/position/{position}', [DocumentController::class, 'position'])
            ->name('position')
            ->middleware('permission:document_update');
        Route::put('/{categoryId}/{id}/publish', [DocumentController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:document_update');
        Route::delete('/{categoryId}/{id}', [DocumentController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:document_delete');

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

    Route::get('/dokumen', [DocumentViewController::class, 'list'])
        ->name('document.list');
    Route::get('/dokumen/{slugCategory}', [DocumentViewController::class, 'readCategory'])
        ->name('document.category.read');
    Route::get('/dokumen/{slugCategory}/{slugDocument}', [DocumentViewController::class, 'readDocument'])
        ->name('document.read');
});

Route::get('/dokumen/file/{id}/download', [DocumentViewController::class, 'download'])
    ->name('document.download');