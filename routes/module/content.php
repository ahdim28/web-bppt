<?php

use App\Http\Controllers\Admin\Content\CategoryController;
use App\Http\Controllers\Admin\Content\PostController;
use App\Http\Controllers\Admin\Content\SectionController;
use App\Http\Controllers\ContentViewController;
use App\Models\IndexUrl;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin')->group(function () {

    //section
    Route::prefix('section')->name('section.')->group(function () {

        Route::get('/', [SectionController::class, 'index'])
            ->name('index')
            ->middleware('permission:content_sections');
        Route::get('/create', [SectionController::class, 'create'])
            ->name('create')
            ->middleware('permission:content_section_create');
        Route::post('/store', [SectionController::class, 'store'])
            ->name('store')
            ->middleware('permission:content_section_create');
        Route::get('/{id}/edit', [SectionController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:content_section_update');
        Route::put('/{id}', [SectionController::class, 'update'])
            ->name('update')
            ->middleware('permission:content_section_update');
        Route::put('/{id}/position/{position}', [SectionController::class, 'position'])
            ->name('position')
            ->middleware('permission:content_section_update');
        Route::delete('/{id}', [SectionController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:content_section_delete');
            
    });

    //category
    Route::prefix('section/{sectionId}/category')->name('category.')->group(function () {

        Route::get('/', [CategoryController::class, 'index'])
            ->name('index')
            ->middleware('permission:content_categories');
        Route::get('/create', [CategoryController::class, 'create'])
            ->name('create')
            ->middleware('permission:content_category_create');
        Route::post('/store', [CategoryController::class, 'store'])
            ->name('store')
            ->middleware('permission:content_category_create');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:content_category_update');
        Route::put('/{id}', [CategoryController::class, 'update'])
            ->name('update')
            ->middleware('permission:content_category_update');
        Route::put('/{id}/position/{position}', [CategoryController::class, 'position'])
            ->name('position')
            ->middleware('permission:content_category_update');
        Route::put('/{id}/publish', [CategoryController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:content_category_update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:content_category_delete');

    });

    //post
    Route::prefix('section/{sectionId}/post')->name('post.')->group(function () {

        Route::get('/', [PostController::class, 'index'])
            ->name('index')
            ->middleware('permission:content_posts');
        Route::get('/create', [PostController::class, 'create'])
            ->name('create')
            ->middleware('permission:content_post_create');
        Route::post('/', [PostController::class, 'store'])
            ->name('store')
            ->middleware('permission:content_post_create');
        Route::get('/{id}/edit', [PostController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:content_post_update');
        Route::put('/{id}', [PostController::class, 'update'])
            ->name('update')
            ->middleware('permission:content_post_update');
        Route::put('/{id}/publish', [PostController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:content_post_update');
        Route::put('/{id}/selection', [PostController::class, 'selection'])
            ->name('selection')
            ->middleware('permission:content_post_update');
        Route::put('/{id}/position/{position}', [PostController::class, 'position'])
            ->name('position')
            ->middleware('permission:content_post_update');
        Route::delete('/{id}', [PostController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:content_post_delete');
        Route::delete('/{id}/file', [PostController::class, 'destroyFile'])
            ->name('file.destroy')
            ->middleware('permission:content_post_delete');

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
            
    //section
    Route::get('/section', [ContentViewController::class, 'listSection'])
        ->name('section.list');
    //category
    Route::get('/category', [ContentViewController::class, 'listCategory'])
        ->name('category.list');
    //post
    Route::get('/post', [ContentViewController::class, 'listPost'])
        ->name('post.list');

    if (config('custom.setting.index_url') == true) {
        $indexing = IndexUrl::where('urlable_type', 'App\Models\Content\Section')->get();
        if ($indexing->count() > 0) {
            foreach ($indexing as $key => $value) {
                Route::get($value->slug, [ContentViewController::class, 'readSection'])
                    ->name('section.read.'.$value->slug);

                //category
                Route::get($value->slug.'/cat/{slugCategory}', [ContentViewController::class, 'readCategory'])
                    ->name('category.read.'.$value->slug);

                //post
                Route::get($value->slug.'/{slugPost}', [ContentViewController::class, 'readPost'])
                    ->name('post.read.'.$value->slug);
            }
        }
    }

});