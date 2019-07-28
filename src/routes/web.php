<?php

Route::group(['prefix' => 'server/{server}/mods','namespace' => 'ItVision\ModManager\http', 'middleware' => ['web', 'csrf', 'auth', 'server', 'subuser.auth', 'node.maintenance']], function () {
    Route::get('/', 'ModController@index')->name('server.modmanager.index');
    Route::post('/install/{mod}', 'ModController@install')->name('server.modmanager.install');
    Route::post('/remove/{mod}', 'ModController@remove')->name('server.modmanager.remove');
});

Route::group(['prefix' => '/admin', 'namespace'=>'ItVision\ModManager\http\admin', 'middleware' => ['web','auth']], function (){
    Route::resource('mod', 'AdminModController');
    Route::resource('category','ModCategoryController');
});