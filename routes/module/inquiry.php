<?php

use App\Http\Controllers\Admin\Inquiry\InquiryController;
use App\Http\Controllers\Admin\Inquiry\InquiryFieldController;
use App\Http\Controllers\InquiryViewController;
use App\Models\IndexUrl;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin/inquiry')->name('inquiry.')
    ->group(function () {

    Route::get('/', [InquiryController::class, 'index'])
        ->name('index')
        ->middleware('permission:inquiries');
   
    Route::get('/create', [InquiryController::class, 'create'])
        ->name('create')
        ->middleware('permission:inquiry_create');
    Route::post('/', [InquiryController::class, 'store'])
        ->name('store')
        ->middleware('permission:inquiry_create');
    Route::get('/{id}/edit', [InquiryController::class, 'edit'])
        ->name('edit')
        ->middleware('permission:inquiry_update');
    Route::put('/{id}/update', [InquiryController::class, 'update'])
        ->name('update')
        ->middleware('permission:inquiry_update');
    Route::put('/{id}/publish', [InquiryController::class, 'publish'])
        ->name('publish')
        ->middleware('permission:inquiry_update');
    Route::put('/{id}/position/{position}', [InquiryController::class, 'position'])
        ->name('position')
        ->middleware('permission:inquiry_update');
    Route::delete('/{id}', [InquiryController::class, 'destroy'])
        ->name('destroy')
        ->middleware('permission:inquiry_delete');

    //form
    Route::get('/{id}/detail', [InquiryController::class, 'detail'])
        ->name('detail')
        ->middleware('permission:inquiry_detail');
    Route::post('/{id}/export', [InquiryController::class, 'exportForm'])
        ->name('export')
        ->middleware('permission:inquiry_detail');
    Route::put('/{id}/detail/{formId}/status', [InquiryController::class, 'statusForm'])
        ->name('detail.status')
        ->middleware('permission:inquiry_detail');
    Route::delete('/{inquiryId}/form/{id}', [InquiryController::class, 'destroyForm'])
        ->name('destroy')
        ->middleware('permission:inquiry_detail');

    //field
    Route::prefix('{inquiryId}/field')->name('field.')->middleware('permission:inquiry_field')
        ->group(function () {
        
        Route::get('/', [InquiryFieldController::class, 'index'])
            ->name('index');
        Route::get('/create', [InquiryFieldController::class, 'create'])
            ->name('create');
        Route::post('/', [InquiryFieldController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [InquiryFieldController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}/update', [InquiryFieldController::class, 'update'])
            ->name('update');
        Route::put('/{id}/position/{position}', [InquiryFieldController::class, 'position'])
            ->name('position');
        Route::delete('/{id}', [InquiryFieldController::class, 'destroy'])
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

    //inquiry
    Route::get('/inquiry', [InquiryViewController::class, 'list'])
        ->name('inquiry.list');
    if (config('custom.setting.index_url') == true) {
        $indexing = IndexUrl::where('urlable_type', 'App\Models\Inquiry\Inquiry')->get();
        if ($indexing->count() > 0) {
            foreach ($indexing as $key => $value) {
                Route::get($value->slug, [InquiryViewController::class, 'read'])
                    ->name('inquiry.read.'.$value->slug);
            }
        }
    }
});

//submit form
Route::post('/inquiry/{id}/submit', [InquiryViewController::class, 'submitForm'])
    ->name('inquiry.submit');