<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Shopify\Auth\FileSessionStorage;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', function (Request $request) {

    Shopify\Context::initialize(
        "1c9726d70aba1c6838b71222733b0889",
        "b86c924cbaa3e22f904eeaf4d4075d5b",
        "read_products,write_products",
        "flash-sales.americaa.de",
        new FileSessionStorage(base_path() . '/tmp/php_sessions'),
        '2022-04',
        true,
        false,
    );


    setcookie("sessionid", md5("youtube-manager.myshopify.com"));
    return Redirect::to(Shopify\Auth\OAuth::begin(
        "youtube-manager.myshopify.com",
        "/callback",
        true,
    ));

});


Route::get('/callback', function (Request $request) {

    Shopify\Context::initialize(
        "1c9726d70aba1c6838b71222733b0889",
        "b86c924cbaa3e22f904eeaf4d4075d5b",
        "read_products,write_products",
        "flash-sales.americaa.de",
        new FileSessionStorage(base_path() . '/tmp/php_sessions'),
        '2022-04',
        true,
        false,
    );

    dd(Shopify\Auth\OAuth::callback([
        "sessionid" => md5($_GET["shop"]),
    ], $_GET));
})->name("callback");
