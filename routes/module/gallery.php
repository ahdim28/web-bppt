<?php

use App\Http\Controllers\Admin\Gallery\AlbumCategoryController;
use App\Http\Controllers\Admin\Gallery\AlbumController;
use App\Http\Controllers\Admin\Gallery\PhotoController;
use App\Http\Controllers\Admin\Gallery\PlaylistCategoryController;
use App\Http\Controllers\Admin\Gallery\PlaylistController;
use App\Http\Controllers\Admin\Gallery\VideoController;
use App\Http\Controllers\GalleryViewController;
use Illuminate\Support\Facades\Route;

/**
 * backend
 */
Route::middleware(['auth'])->prefix('admin/gallery')->name('gallery.')
    ->group(function () {

    //album
    Route::prefix('album')->name('album.')->group(function () {

        //category
        Route::prefix('category')->name('category.')->group(function () {
            
            Route::get('/', [AlbumCategoryController::class, 'index'])
                ->name('index')
                ->middleware('permission:gallery_category_albums');
            Route::get('/create', [AlbumCategoryController::class, 'create'])
                ->name('create')
                ->middleware('permission:gallery_category_album_create');
            Route::post('/', [AlbumCategoryController::class, 'store'])
                ->name('store')
                ->middleware('permission:gallery_category_album_create');
            Route::get('/{id}/edit', [AlbumCategoryController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:gallery_category_album_update');
            Route::put('/{id}', [AlbumCategoryController::class, 'update'])
                ->name('update')
                ->middleware('permission:gallery_category_album_update');
            Route::put('/{id}/publish', [AlbumCategoryController::class, 'publish'])
                ->name('publish')
                ->middleware('permission:gallery_category_album_update');
            Route::put('/{id}/position/{position}', [AlbumCategoryController::class, 'position'])
                ->name('position')
                ->middleware('permission:gallery_category_album_update');
            Route::delete('/{id}', [AlbumCategoryController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:gallery_category_album_delete');

        });

        Route::get('/', [AlbumController::class, 'index'])
            ->name('index')
            ->middleware('permission:albums');
        Route::get('/create', [AlbumController::class, 'create'])
            ->name('create')
            ->middleware('permission:album_create');
        Route::post('/', [AlbumController::class, 'store'])
            ->name('store')
            ->middleware('permission:album_create');
        Route::get('/{id}/edit', [AlbumController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:album_update');
        Route::put('/{id}', [AlbumController::class, 'update'])
            ->name('update')
            ->middleware('permission:album_update');
        Route::put('/{id}/publish', [AlbumController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:album_update');
        Route::put('/{id}/position/{position}', [AlbumController::class, 'position'])
            ->name('position')
            ->middleware('permission:album_update');
        Route::post('/sort', [AlbumController::class, 'sort'])
            ->name('sort')
            ->middleware('permission:album_update');
        Route::delete('/{id}', [AlbumController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:album_delete');

        //photo
        Route::prefix('{albumId}/photo')->name('photo.')->middleware('permission:photos')
            ->group(function () {

            Route::get('/', [PhotoController::class, 'index'])
                ->name('index');
            Route::get('/create', [PhotoController::class, 'create'])
                ->name('create');
            Route::post('/', [PhotoController::class, 'store'])
                ->name('store');
            Route::get('/{id}/edit', [PhotoController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [PhotoController::class, 'update'])
                ->name('update');
            Route::put('/{id}/publish', [PhotoController::class, 'publish'])
                ->name('publish');
            Route::put('/{id}/position/{position}', [PhotoController::class, 'position'])
                ->name('position');
            Route::post('/sort', [PhotoController::class, 'sort'])
                ->name('sort');
            Route::delete('/{id}', [PhotoController::class, 'destroy'])
                ->name('destroy');
            
        });

    });

    //playlist
    Route::prefix('playlist')->name('playlist.')->group(function () {

         //category
         Route::prefix('category')->name('category.')->group(function () {
            
            Route::get('/', [PlaylistCategoryController::class, 'index'])
                ->name('index')
                ->middleware('permission:gallery_category_playlists');
            Route::get('/create', [PlaylistCategoryController::class, 'create'])
                ->name('create')
                ->middleware('permission:gallery_category_playlist_create');
            Route::post('/', [PlaylistCategoryController::class, 'store'])
                ->name('store')
                ->middleware('permission:gallery_category_playlist_create');
            Route::get('/{id}/edit', [PlaylistCategoryController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:gallery_category_playlist_update');
            Route::put('/{id}', [PlaylistCategoryController::class, 'update'])
                ->name('update')
                ->middleware('permission:gallery_category_playlist_update');
            Route::put('/{id}/publish', [PlaylistCategoryController::class, 'publish'])
                ->name('publish')
                ->middleware('permission:gallery_category_playlist_update');
            Route::put('/{id}/position/{position}', [PlaylistCategoryController::class, 'position'])
                ->name('position')
                ->middleware('permission:gallery_category_playlist_update');
            Route::delete('/{id}', [PlaylistCategoryController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:gallery_category_playlist_delete');

        });

        Route::get('/', [PlaylistController::class, 'index'])
            ->name('index')
            ->middleware('permission:playlists');
        Route::get('/create', [PlaylistController::class, 'create'])
            ->name('create')
            ->middleware('permission:playlist_create');
        Route::post('/', [PlaylistController::class, 'store'])
            ->name('store')
            ->middleware('permission:playlist_create');
        Route::get('/{id}/edit', [PlaylistController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:playlist_update');
        Route::put('/{id}', [PlaylistController::class, 'update'])
            ->name('update')
            ->middleware('permission:playlist_update');
        Route::put('/{id}/publish', [PlaylistController::class, 'publish'])
            ->name('publish')
            ->middleware('permission:playlist_update');
        Route::put('/{id}/position/{position}', [PlaylistController::class, 'position'])
            ->name('position')
            ->middleware('permission:playlist_update');
        Route::post('/sort', [PlaylistController::class, 'sort'])
            ->name('sort')
            ->middleware('permission:playlist_update');
        Route::delete('/{id}', [PlaylistController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:playlist_delete');

        //video
        Route::prefix('{playlistId}/video')->name('video.')->middleware('permission:videos')
            ->group(function () {

            Route::get('/', [VideoController::class, 'index'])
                ->name('index');
            Route::get('/create', [VideoController::class, 'create'])
                ->name('create');
            Route::post('/', [VideoController::class, 'store'])
                ->name('store');
            Route::get('/{id}/edit', [VideoController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [VideoController::class, 'update'])
                ->name('update');
            Route::put('/{id}/publish', [VideoController::class, 'publish'])
                ->name('publish');
            Route::put('/{id}/position/{position}', [VideoController::class, 'position'])
                ->name('position');
            Route::post('/sort', [VideoController::class, 'sort'])
                ->name('sort');
            Route::delete('/{id}', [VideoController::class, 'destroy'])
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

    Route::prefix('gallery')->name('gallery.')->group(function () {

        Route::get('/', [GalleryViewController::class, 'list'])
            ->name('list');
        //album
        Route::get('/photo', [GalleryViewController::class, 'listCatAlbum'])
            ->name('photo');
        Route::get('/photo/{slugCategory}', [GalleryViewController::class, 'readCatAlbum'])
            ->name('photo.category');
        Route::get('/photo/{slugCategory}/{slugAlbum}', [GalleryViewController::class, 'readAlbum'])
            ->name('photo.category.album');
        //playlist
        Route::get('/video', [GalleryViewController::class, 'listCatPlaylist'])
            ->name('video');
        Route::get('/video/{slugCategory}', [GalleryViewController::class, 'readCatPlaylist'])
            ->name('video.category');
        Route::get('/video/{slugCategory}/{slugPlaylist}', [GalleryViewController::class, 'readPlaylist'])
            ->name('video.category.playlist');
        
    });
        
});