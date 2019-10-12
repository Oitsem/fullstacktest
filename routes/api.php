<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/auth/user', 'AuthController@user');

    // Guest
    Route::Resource('guests', 'GuestsController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);

    // User
    Route::resource('users', 'UsersController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);
});
