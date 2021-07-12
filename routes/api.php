<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'auth','namespace'=>'Auth'], function(){
    Route::post('signin','SignInController');
    Route::get('me','MeController');
    Route::post('signout','SignOutController');
});

Route::group(['prefix'=>'snippets','namespace'=>'Snippets'], function(){
    Route::get('', 'SnippetController@index');
    Route::post('', 'SnippetController@store');
    Route::get('{snippet}', 'SnippetController@show');
    Route::patch('{snippet}', 'SnippetController@update');
    Route::patch('{snippet}/steps/{step}', 'StepController@update');
    Route::post('{snippet}/steps/', 'StepController@store');
    Route::delete('{snippet}/steps/{step}', 'StepController@destroy');
});

Route::group(['prefix'=>'me','namespace'=>'Me'], function(){
    Route::get('snippets', 'SnippetController@index');
});
