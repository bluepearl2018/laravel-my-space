<?php

Route::middleware(['web', 'auth:admin'])->get('/setup/my-space/config', function () {
    return view('my-space::config');
})->name('setup.my-space.config');
