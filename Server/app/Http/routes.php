<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Models\Menu;
use App\Models\Shop;

Route::post('/', function(){
    $shop_id = request()->get('id');
    $shop=\App\Models\Shop::findOrNew($shop_id);
    $table = request()->get('table');

    $result = $shop->toArray();
    $result['token'] = Crypt::encrypt(json_encode([
        'id' => $shop_id,
        'table' => $table
    ]));

    return response()->json($result);
});

Route::model('shop', \App\Models\Shop::class);
Route::model('menu', \App\Models\Menu::class);
Route::model('order', \App\Models\Order::class);

Route::resource('shop', 'ShopController');
Route::get('shop/{shop}/qr',['as'=>'shop.qr.form', function(Shop $shop){
    return view('dialog.qr', [
        'shop' => $shop
    ]);
}]);
Route::post('shop/{shop}/qr',['as'=>'shop.qr.generation', function(Shop $shop){

}]);
Route::resource('shop.menu', 'ShopMenuController');
Route::resource('order', 'OrderController');
Route::resource('shop.order', 'ShopOrderController', [
    'only' => ['index']
]);
Route::get('/', function(){
    return redirect()->route('shop.index');
});