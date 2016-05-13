<?php

define('DIR_GSDW_PERMISSION', __DIR__);

global $namespaceGsdwController;
$namespaceGsdwController = '\Gsdw\Permission\Controllers\\';
Route::group([
    'middleware' => ['web', 'auth'],
    'as' => 'auth.'
], function() {
    //Role Manage
    Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
        global $namespaceGsdwController;
        Route::get('/', $namespaceGsdwController . 'RoleController@index')
                ->name('list');
        Route::get('/create', $namespaceGsdwController . 'RoleController@create')
                ->name('createForm');
        Route::post('/create', $namespaceGsdwController . 'RoleController@createPost')
                ->name('createPost');
        Route::get('/edit/{id}', $namespaceGsdwController . 'RoleController@edit')
                ->where('id', '[0-9]+')
                ->name('editForm');
        Route::post('/edit/{id}', $namespaceGsdwController . 'RoleController@editPost')
                ->name('editPost');
        Route::get('/delete/{id}/{token}', $namespaceGsdwController . 'RoleController@delete')
                ->where('id', '[0-9]+')->name('delete');
        Route::post('/massAction', $namespaceGsdwController . 'RoleController@massAction')
                ->name('massAction');
        
        //Role Group Manage
        Route::group(['prefix' => 'group', 'as' => 'group.'], function () {
            global $namespaceGsdwController;
            Route::get('/', $namespaceGsdwController . 'RoleGroupController@index')
                    ->name('list');
            Route::get('/create', $namespaceGsdwController . 'RoleGroupController@create')
                    ->name('createForm');
            Route::post('/create', $namespaceGsdwController . 'RoleGroupController@createPost')
                    ->name('createPost');
            Route::get('/edit/{id}', $namespaceGsdwController . 'RoleGroupController@edit')
                    ->where('id', '[0-9]+')->name('editForm');
            Route::post('/edit/{id}', $namespaceGsdwController . 'RoleGroupController@editPost')
                    ->name('editPost');
            Route::get('/delete/{id}/{token}', $namespaceGsdwController . 'RoleGroupController@delete')
                    ->where('id', '[0-9]+')->name('delete');
            Route::post('/massAction', $namespaceGsdwController . 'RoleGroupController@massAction')
                    ->name('massAction');
        });
    });
    
    //users
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        global $namespaceGsdwController;
        Route::get('/', $namespaceGsdwController . 'UserController@index')
                ->name('list');
        Route::get('/create', $namespaceGsdwController . 'UserController@create')
                ->name('createForm');
        Route::post('/create', $namespaceGsdwController . 'UserController@createPost')
                ->name('createPost');
        Route::get('/edit/{id}', $namespaceGsdwController . 'UserController@edit')
                ->where('id', '[0-9]+')
                ->name('editForm');
        Route::post('/edit/{id}', $namespaceGsdwController . 'UserController@editPost')
                ->name('editPost');
        Route::get('/delete/{id}/{token}', $namespaceGsdwController . 'UserController@delete')
                ->where('id', '[0-9]+')->name('delete');
        Route::post('/massAction', $namespaceGsdwController . 'UserController@massAction')
                ->name('massAction');
    });
});
