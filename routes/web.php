<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Убираем роуты аутентификации
Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,

]);

//Admin
Route::group(['middleware' => 'auth',
    'namespace' => 'Admin',
    'prefix' => 'admin',
], function () {
    Route::group(['middleware' => 'is_admin'], function () {
        Route::get('/orders', 'OrderController@index')->name('home');
    });

    Route::resource('categories', 'CategoryController');
    Route::resource('products', 'ProductController');

});


Route::get('/logout', 'Auth\LoginController@logout')->name('get-logout');

Route::get('/', 'MainController@index')->name('index');

//Basket
Route::group(['prefix' => 'basket'], function () {
    Route::post('/add/{id}', 'BasketController@basketAdd')->name('basket-add');

    Route::group([
        'middleware' => 'basket_is_not_empty',
    ], function () {
        Route::post('/remove/{id}', 'BasketController@basketRemove')->name('basket-remove');
        Route::get('/', 'BasketController@basket')->name('basket');
        Route::get('/place', 'BasketController@basketPlace')->name('basket-place');
        Route::post('/place', 'BasketController@basketConfirm')->name('basket-confirm');
    });
});


//Categories
Route::get('/categories', 'MainController@categories')->name('categories');
Route::get('/{category}', 'MainController@category')->name('category');
Route::get('/{category}/{product?}', 'MainController@product')->name('product');





