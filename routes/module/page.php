<?php

use App\Http\Controllers\Admin\Page\PageController;
use App\Http\Controllers\PageViewController;
use App\Models\IndexUrl;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::prefix('page')->name('page.')->group(function () {

        Route::get('/', [PageController::class, 'index'])
            ->name('index')
            ->middleware('permission:pages');
        Route::get('/create', [PageController::class, 'create'])
            ->name('create')
            ->middleware('permission:page_create');
        Route::post('/store', [PageController::class, 'store'])
            ->name('store')
            ->middleware('permission:page_create');
        Route::get('/{id}/edit', [PageController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:page_update');
        Route::put('/{id}', [PageController::class, 'update'])
            ->name('update')
            ->middleware('permission:page_update');
        Route::put('/{id}/publish', [PageController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:page_update');
        Route::put('/{id}/position/{position}', [PageController::class, 'position'])
            ->name('position')
            ->middleware('permission:page_update');
        Route::delete('/{id}', [PageController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:page_delete');

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

    //pages
    Route::get('/page', [PageViewController::class, 'list'])
        ->name('page.list');
    
    if (config('custom.setting.index_url') == true) {
        $indexing = IndexUrl::where('urlable_type', 'App\Models\Page\Page')->get();
        if ($indexing->count() > 0) {
            foreach ($indexing as $key => $value) {
                Route::get($value->slug, [PageViewController::class, 'read'])
                    ->name('page.read.'.$value->slug);
            }
        }
    }
        
});