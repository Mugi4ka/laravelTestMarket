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

Route::get('parser', 'ParserController@parserIndex')->name('parser');
Route::get('parserhtml', 'ParserController@parserhtml')->name('parseHtml');
Route::get('sitemapGenerator', 'ParserController@sitemapGenerator')->name('sitemapGenerator');

Route::get('locale/{locale}', 'MainController@changeLocale')->name('locale');
Route::get('currency/{currencyCode}', 'MainController@changeCurrency')->name('currency');
Route::get('/logout', 'Auth\LoginController@logout')->name('get-logout');

Route::middleware('set_locale')->group(function () {
    Route::get('reset', "ResetController@reset")->name('reset');

    Route::middleware(['auth'])->group(function () {
        Route::group([
            'prefix' => 'person',
            'namespace' => 'Person',
            'as' => 'person.',
        ], function () {
            Route::get('/orders', 'OrderController@index')->name('orders.index');
            Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
        });


        Route::group([
            'namespace' => 'Admin',
            'prefix' => 'admin',
        ], function () {
            Route::group(['middleware' => 'is_admin'], function () {
                Route::get('/orders', 'OrderController@index')->name('home');
                Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
            });

            Route::resource('categories', 'CategoryController');
            Route::resource('products', 'ProductController');
            Route::resource('products/{product}/skus', 'SkuController');
            Route::resource('properties', 'PropertyController');
            Route::resource('merchants', 'MerchantController');
            Route::get('merchant/{merchant}/update_token', 'MerchantController@updateToken')->name('merchants.update_token');
            Route::resource('properties/{property}/property-options', 'PropertyOptionController');
            Route::resource('coupons', 'CouponController');

        });
    });


    Route::get('/', 'MainController@index')->name('index');
    Route::post('subscription/{skus}', "MainController@subscribe")->name('subscription');


//Basket
    Route::group(['prefix' => 'basket'], function () {
        Route::post('/add/{skus}', 'BasketController@basketAdd')->name('basket-add');

        Route::group([
            'middleware' => 'basket_is_not_empty',
        ], function () {
            Route::post('/remove/{skus}', 'BasketController@basketRemove')->name('basket-remove');
            Route::get('/', 'BasketController@basket')->name('basket');
            Route::get('/place', 'BasketController@basketPlace')->name('basket-place');
            Route::post('/place', 'BasketController@basketConfirm')->name('basket-confirm');
            Route::post('coupon', 'BasketController@setCoupon')->name('set-coupon');
        });
    });


//Categories
    Route::get('/categories', 'MainController@categories')->name('categories');
    Route::get('/{category}', 'MainController@category')->name('category');
    Route::get('/{category}/{product}/{skus}', 'MainController@sku')->name('sku');

});
