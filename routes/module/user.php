<?php

use App\Http\Controllers\Admin\Users\ACL\PermissionController;
use App\Http\Controllers\Admin\Users\ACL\RoleController;
use App\Http\Controllers\Admin\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {

    //ACL
    Route::prefix('acl')->middleware('role:super')->group(function () {

        //roles
        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])
                ->name('index');
            Route::post('/', [RoleController::class, 'store'])
                ->name('store');
            Route::put('/{id}', [RoleController::class, 'update'])
                ->name('update')
                ->middleware('role:super');
            Route::get('/{id}/permission', [RoleController::class, 'permission'])
                ->name('permission');
            Route::put('/{id}/permission', [RoleController::class, 'setPermission']);
            Route::delete('/{id}', [RoleController::class, 'destroy'])
                ->name('destroy');
        });
        
        //permission
        Route::prefix('permission')->name('permission.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])
                ->name('index');
            Route::post('/', [PermissionController::class, 'store'])
                ->name('store');
            Route::put('/{id}', [PermissionController::class, 'update'])
                ->name('update');
            Route::delete('/{id}', [PermissionController::class, 'destroy'])
                ->name('destroy');
        });

    });

    //users
    Route::prefix('user')->name('user.')->group(function () {

        Route::get('/', [UserController::class, 'index'])
            ->name('index')
            ->middleware('permission:users');
        Route::get('/trash', [UserController::class, 'trash'])
            ->name('trash')
            ->middleware('role:super');
        Route::get('/create', [UserController::class, 'create'])
            ->name('create')
            ->middleware('permission:user_create');
        Route::post('/', [UserController::class, 'store'])
            ->name('store')
            ->middleware('permission:user_create');
        Route::get('/{id}/edit', [UserController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:user_update');
        Route::put('/{id}', [UserController::class, 'update'])
            ->name('update')
            ->middleware('permission:user_update');
        Route::put('/{id}/activate', [UserController::class, 'activate'])
            ->name('activate')
            ->middleware('permission:user_update');
        Route::delete('/{id}/soft', [UserController::class, 'softDelete'])
            ->name('delete.soft')
            ->middleware('permission:user_delete');
        Route::delete('/{id}/permanent', [UserController::class, 'permanentDelete'])
            ->name('delete.permanent')
            ->middleware('permission:user_delete');
        Route::put('/{id}/restore', [UserController::class, 'restore'])
            ->name('restore')
            ->middleware('permission:user_update');
        Route::delete('/delete/{id}/log', [UserController::class, 'logDelete'])
            ->name('log.destroy')
            ->middleware('permission:user_delete');

    });

    //log all
    Route::get('/log', [UserController::class, 'log'])
        ->name('log')
        ->middleware('permission:users');
    Route::get('/log/{id}', [UserController::class, 'logByUser'])
        ->name('log.user');

    //profile
    Route::get('/profile', [UserController::class, 'profile'])
        ->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile']);
    //change photo
    Route::put('/profile/photo/change', [UserController::class, 'changePhoto'])
        ->name('profile.photo.change');
    Route::put('/profile/photo/remove', [UserController::class, 'removePhoto'])
        ->name('profile.photo.remove');
    //verification email
    Route::get('/profile/mail/send', [UserController::class, 'sendMailVerification'])
        ->name('profile.mail.send');
    Route::get('/profile/mail/verification/{email}', [UserController::class, 'verified'])
        ->name('profile.mail.verification');

});