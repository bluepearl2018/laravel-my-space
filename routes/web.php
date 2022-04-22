<?php

use Eutranet\MySpace\Http\Controllers\AccountController;
use Eutranet\MySpace\Http\Controllers\UserDashboardController;
use Eutranet\MySpace\Http\Controllers\UserEmailController;
use Eutranet\MySpace\Http\Controllers\UserAgreementController;
use Eutranet\MySpace\Http\Controllers\UserPaymentController;
use Eutranet\MySpace\Http\Controllers\UserGeneralTermController;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Eutranet\MySpace\Http\Controllers\MySpaceGeneralTermsController;
use Eutranet\Setup\Http\Controllers\GeneralTermController;
use Eutranet\MySpace\Http\Controllers\UserNotificationController;
use Eutranet\MySpace\Http\Controllers\UserSocialMediaController;
use Eutranet\MySpace\Http\Controllers\UserInfoController;

Route::middleware( ['web', 'auth'])->group(function () {

	Route::get('my-space/dashboard', [UserDashboardController::class, 'index'])->name('my-space.dashboard');

	Route::middleware(['verified'])->prefix('my-space')->name('my-space.')->group(function () {

		Route::any('users/{user}/read-and-accept-general-terms/{general_term}', [
			UserGeneralTermController::class, 'readAndAcceptTerms']
		)->name('read-and-accept-general-terms');

		Route::any('users/{user}/read-and-accept-my-space-general-terms/{my_space_general_term}', [
			UserGeneralTermController::class, 'readAndAcceptMySpaceGeneralTerms'
		])->name('read-and-accept-my-space-general-terms');

		/*
		* My space routes
		*/
		Route::middleware('has-accepted-my-space-general-terms-on')->group(function () {

			/**
			 * --------------------------------------------------------------------------
			 * USER ACCOUNTS
			 * --------------------------------------------------------------------------
			 */
			Route::get('users/{user}/account', [AccountController::class, 'show'])->name('my-account');
			Route::put('users/{user}/account', [AccountController::class, 'update'])->name('my-account.update');
			Route::delete('users/{user}/account', [AccountController::class, 'destroy'])->middleware('throttle:deletions')->name('my-account.destroy');
			Route::post('users/{user}/account', [AccountController::class, 'cancelDestroy'])->middleware('throttle:restorations')->name('my-account.cancel-destroy');

			/**
			 * --------------------------------------------------------------------------
			 * USER PROFILE TABS
			 * --------------------------------------------------------------------------
			 */

			Route::get('my-profile/{user}', [UserInfoController::class, 'show'])->name('my-profile');
			Route::get('my-social-medias/{user}', [UserSocialMediaController::class, 'show'])->name('my-social-medias');
			Route::resource('users.user-social-medias', UserSocialMediaController::class)->except(['show'])->names('user-social-medias');

			/**
			 * --------------------------------------------------------------------------
			 * GENERAL TERMS & USER AGREEMENTS
			 * --------------------------------------------------------------------------
			 */
			Route::resource('users.user-agreements', UserAgreementController::class)->names('user-agreements');
			Route::get('my-space-general-terms', [MySpaceGeneralTermsController::class, 'index'])->name('my-space-general-terms.index');
			Route::get('my-space-general-terms/{my_space_general_term}', [MySpaceGeneralTermsController::class, 'show'])->name('my-space-general-terms.show');
			Route::get('general-terms', [GeneralTermController::class, 'index'])->name('general-terms.index');
			Route::get('general-terms/{general_term}', [GeneralTermController::class, 'show'])->name('general-terms.show');

			/**
			 * --------------------------------------------------------------------------
			 * ACCOUNT BASIC FUNCTIONS
			 * --------------------------------------------------------------------------
			 */

			Route::resource('users.user-infos', UserInfoController::class)->names('user-infos');
			Route::resource('users.user-payments', UserPaymentController::class)->names('user-payments');
			Route::resource('users.user-notifications', UserNotificationController::class)->only(['index', 'update'])->names('user-notifications');
			Route::resource('users.emails', UserEmailController::class)
				->except(['edit', 'update', 'delete'])
				->names('emails');

			RateLimiter::for('users.emails.store', function (Request $request) {
				return Limit::perMinute(2);
			});

			/**
			 * --------------------------------------------------------------------------
			 * ACCOUNT CONTACT CENTER FUNCTIONS
			 * --------------------------------------------------------------------------
			 */
		});

	});
});
