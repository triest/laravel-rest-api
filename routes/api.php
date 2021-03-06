<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */

    Route::group([
            'prefix' => 'auth'
    ], function () {
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');

        Route::group([
                'middleware' => 'auth:api'
        ], function () {
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'AuthController@user');
        });
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });


    Route::middleware('auth:api')->prefix('api')->group(
            function () {
                Route::get('/',function (){
                    return response()->json(["tst"=>"test"]);
                });

            }
    );


    Route::middleware('auth:api')->group(
            function () {
                Route::get('/',function (){
                    return response()->json(["tst"=>"test"]);
                });


                //create Order
                Route::post('/order','OrderController@createOrder');
                Route::get('/orders','OrderController@getOrders');


                Route::put('/order-requwest/{id}/cancel','OrderController@cancelOrderRequwest');

                // создание заявки на заказ
                Route::post('/order-requwest','OrderController@createOrderRequwest');

                //получить свои заявки
                Route::get('/order-requwest','OrderController@getMyOrderRequwest');
                Route::post('/order-accept','OrderController@acceptOrder');


                Route::put('/order/mark-completed/{id}','OrderController@markCompleted');
            }
    );


