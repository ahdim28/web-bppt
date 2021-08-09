<?php

use App\Http\Controllers\Admin\Link\LinkController;
use App\Http\Controllers\Admin\Link\LinkMediaController;
use App\Http\Controllers\LinkViewController;
use App\Models\IndexUrl;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin/link')->name('link.')
    ->group(function () {
    
    Route::get('/', [LinkController::class, 'index'])
        ->name('index')
        ->middleware('permission:links');
    Route::get('/create', [LinkController::class, 'create'])
        ->name('create')
        ->middleware('permission:link_create');
    Route::post('/', [LinkController::class, 'store'])
        ->name('store')
        ->middleware('permission:link_create');
    Route::get('/{id}/edit', [LinkController::class, 'edit'])
        ->name('edit')
        ->middleware('permission:link_update');
    Route::put('/{id}', [LinkController::class, 'update'])
        ->name('update')
        ->middleware('permission:link_update');
    Route::put('/{id}/publish', [LinkController::class, 'publish'])
        ->name('publish')
        ->middleware('permission:link_update');
    Route::put('/{id}/position/{position}', [LinkController::class, 'position'])
        ->name('position')
        ->middleware('permission:link_update');
    Route::delete('/{id}', [LinkController::class, 'destroy'])
        ->name('destroy')
        ->middleware('permission:link_delete');

    //media
    Route::prefix('{linkId}/media')->name('media.')->middleware('permission:link_medias')
        ->group(function () {
        
        Route::get('/', [LinkMediaController::class, 'index'])
            ->name('index');
        Route::get('/create', [LinkMediaController::class, 'create'])
            ->name('create');
        Route::post('/', [LinkMediaController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [LinkMediaController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [LinkMediaController::class, 'update'])
            ->name('update');
        Route::put('/{id}/position/{position}', [LinkMediaController::class, 'position'])
            ->name('position');
        Route::delete('/{id}', [LinkMediaController::class, 'destroy'])
            ->name('destroy');

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

    //link
    Route::get('/link', [LinkViewController::class, 'list'])
        ->name('link.list');
    if (config('custom.setting.index_url') == true) {
        $indexing = IndexUrl::where('urlable_type', 'App\Models\Link\Link')->get();
        if ($indexing->count() > 0) {
            foreach ($indexing as $key => $value) {
                Route::get($value->slug, [LinkViewController::class, 'read'])
                    ->name('link.read.'.$value->slug);
            }
        }
    }

});