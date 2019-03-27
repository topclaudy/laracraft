<?php

use Illuminate\Support\Facades\Route;

Route::get('/api/theme', 'ThemeController@index')->name('laracraft.api.theme.index');
Route::get('/api/theme/{theme}', 'ThemeController@get')->name('laracraft.api.theme.get');
Route::post('/api/theme/{theme}', 'ThemeController@configure')->name('laracraft.api.theme.configure');

Route::get('/api/block', 'BlockController@index')->name('laracraft.api.block.index');
Route::get('/api/block/{block}', 'BlockController@get')->name('laracraft.api.block.get');
Route::post('/api/block', 'BlockController@store')->name('laracraft.api.block.post');
Route::put('/api/block/{block}', 'BlockController@update')->name('laracraft.api.block.put');
Route::delete('/api/block/{block}', 'BlockController@delete')->name('laracraft.api.block.delete');

Route::get('/api/component', 'ComponentController@index')->name('laracraft.api.component.index');

Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('laracraft');
