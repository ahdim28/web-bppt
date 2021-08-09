<?php

use App\Http\Controllers\Admin\Master\CommentController;
use App\Http\Controllers\Admin\Master\Field\FieldCategoryController;
use App\Http\Controllers\Admin\Master\Field\FieldController;
use App\Http\Controllers\Admin\Master\MediaController;
use App\Http\Controllers\Admin\Master\TagController;
use App\Http\Controllers\Admin\Master\TemplateController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {

    //templates
    Route::prefix('template')->name('template.')->middleware('role:super')
        ->group(function () {

        Route::get('/', [TemplateController::class, 'index'])
            ->name('index');
        Route::get('/create', [TemplateController::class, 'create'])
            ->name('create');
        Route::post('/store', [TemplateController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [TemplateController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [TemplateController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [TemplateController::class, 'destroy'])
            ->name('destroy');

    });

    //fields
    Route::prefix('field/category')->name('field.')->group(function () {

        //category
        Route::get('/', [FieldCategoryController::class, 'index'])
            ->name('category')
            ->middleware('permission:fields');
        Route::get('/create', [FieldCategoryController::class, 'create'])
            ->name('category.create')
            ->middleware('permission:field_create');
        Route::post('/category', [FieldCategoryController::class, 'store'])
            ->name('category.store')
            ->middleware('permission:field_create');
        Route::get('/{id}/edit', [FieldCategoryController::class, 'edit'])
            ->name('category.edit')
            ->middleware('permission:field_update');
        Route::put('/{id}', [FieldCategoryController::class, 'update'])
            ->name('category.update')
            ->middleware('permission:field_update');
        Route::delete('/{id}', [FieldCategoryController::class, 'destroy'])
            ->name('category.destroy')
            ->middleware('permission:field_delete');

        //field
        Route::get('/{categoryId}', [FieldController::class, 'index'])
            ->name('index')
            ->middleware('permission:fields');
        Route::get('/{categoryId}/create', [FieldController::class, 'create'])
            ->name('create')
            ->middleware('permission:field_create');
        Route::post('/{categoryId}', [FieldController::class, 'store'])
            ->name('store')
            ->middleware('permission:field_create');
        Route::get('/{categoryId}/{id}/edit', [FieldController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:field_update');
        Route::put('/{categoryId}/{id}', [FieldController::class, 'update'])
            ->name('update')
            ->middleware('permission:field_update');
        Route::delete('/{categoryId}/{id}', [FieldController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:field_delete');

    });

    //medias
    Route::prefix('media/{moduleId}/{moduleName}')->name('media.')->group(function () {

        Route::get('/', [MediaController::class, 'index'])
            ->name('index')
            ->middleware('permission:medias');
        Route::get('/create', [MediaController::class, 'create'])
            ->name('create')
            ->middleware('permission:media_create');
        Route::post('/', [MediaController::class, 'store'])
            ->name('store')
            ->middleware('permission:media_create');
        Route::get('/{id}/edit', [MediaController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:media_update');
        Route::put('/{id}', [MediaController::class, 'update'])
            ->name('update')
            ->middleware('permission:media_update');
        Route::post('/sort', [MediaController::class, 'sort'])
            ->name('sort')
            ->middleware('permission:media_update');
        Route::delete('/{id}/delete', [MediaController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:media_delete');
    });

    //tags
    Route::prefix('tag')->name('tag.')->group(function () {

        Route::get('/', [TagController::class, 'index'])
            ->name('index')
            ->middleware('permission:tags');
        Route::get('/create', [TagController::class, 'create'])
            ->name('create')
            ->middleware('permission:tag_create');
        Route::post('/store', [TagController::class, 'store'])
            ->name('store')
            ->middleware('permission:tag_create');
        Route::get('/{id}/edit', [TagController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:tag_update');
        Route::put('/{id}', [TagController::class, 'update'])
            ->name('update')
            ->middleware('permission:tag_update');
        Route::put('/{id}/flags', [TagController::class, 'flags'])
            ->name('flags')
            ->middleware('permission:tag_update');
        Route::put('/{id}/standar', [TagController::class, 'standar'])
            ->name('standar')
            ->middleware('permission:tag_update');
        Route::delete('/{id}', [TagController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:tag_delete');

    });

    //comments
    Route::prefix('comment')->name('comment.')->group(function () {

        Route::get('/', [CommentController::class, 'index'])
            ->name('index')
            ->middleware('permission:comments');
        Route::get('/{id}/detail', [CommentController::class, 'detail'])
            ->name('detail')
            ->middleware('permission:comments');
        Route::post('/store', [CommentController::class, 'store'])
            ->name('store')
            ->middleware('permission:comment_create');
        Route::post('/store/{id}/reply', [CommentController::class, 'storeReply'])
            ->name('store.reply')
            ->middleware('permission:comment_create');
        Route::put('/{id}', [CommentController::class, 'update'])
            ->name('update')
            ->middleware('permission:comment_update');
        Route::put('/{id}/reply', [CommentController::class, 'updateReply'])
            ->name('update.reply')
            ->middleware('permission:comment_update');
        Route::put('/{id}/flags', [CommentController::class, 'flags'])
            ->name('flags')
            ->middleware('permission:comment_update');
        Route::put('/{id}/flags/reply', [CommentController::class, 'flagsReply'])
            ->name('flags.reply')
            ->middleware('permission:comment_update');
        Route::delete('/{id}', [CommentController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:comment_delete');
        Route::delete('/{id}/reply', [CommentController::class, 'destroyReply'])
            ->name('destroy.reply')
            ->middleware('permission:comment_delete');

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

    Route::prefix('comment')->name('comment.')->middleware(['auth'])->group(function () {
        
    });

});