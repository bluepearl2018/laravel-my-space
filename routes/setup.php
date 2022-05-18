<?php


use Eutranet\MySpace\Http\Controllers\MySpaceInstallationController;
use Eutranet\MySpace\Http\Controllers\UserSocialMediaController;
use Eutranet\MySpace\Http\Controllers\UserPaymentController;
use Eutranet\MySpace\Http\Controllers\UserAccountController;
use Eutranet\MySpace\Http\Controllers\MySpaceGeneralTermController;
use Eutranet\MySpace\Http\Controllers\UserInfoController;

Route::middleware(['web', 'auth:admin'])->prefix('setup')->name('setup.')->group(function () {
    Route::get('installation/my-space', [MySpaceInstallationController::class, 'index'])->name('installation.my-space');
    // Route::resource('dashboard-menus', DashboardMenuController::class)->names('dashboard-menus');
    Route::resource('my-space-general-terms', MySpaceGeneralTermController::class)->names('my-space-general-terms');
    Route::resource('my-space-users', UserAccountController::class)->names('my-space-users');
    Route::resource('user-infos', UserInfoController::class)->names('user-infos');
    Route::resource('user-payments', UserPaymentController::class)->names('user-payments');
    Route::resource('user-social-medias', UserSocialMediaController::class)->names('user-social-medias');
});
