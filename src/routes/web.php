<?php
/**
 * Created by PhpStorm.
 * User: miliv
 * Date: 6/18/2019
 * Time: 4:33 PM
 */



Route::group(['prefix' => 'server/{server}/mods','namespace' => 'ItVision\ModManager\http', 'middleware' => ['web','auth']], function () {
    Route::get('/', 'ModController@index')->name('server.modmanager.inItVision\Mod\httpdex');
    Route::post('/install/{mod}', 'ModController@install')->name('server.modmanager.install');
    Route::post('/remove/{mod}', 'ModController@remove')->name('server.modmanager.remove');
});


Route::group(['prefix' => '/admin', 'namespace'=>'ItVision\ModManager\http\admin', 'middleware' => ['web','auth']], function (){
    Route::resource('mod', 'AdminModController');
    Route::resource('category', 'ModCategoryController');
});
