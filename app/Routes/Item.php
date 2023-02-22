<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;

class Item
{
    public static function routesItem($middlware = [], $prefix = '')
    {
        return Route::group(['middleware' => $middlware, 'prefix' => $prefix], function () {
            Route::get('/items', [\App\Http\Controllers\item\ItemController::class, 'getAllItems']);
            Route::post('/items', [\App\Http\Controllers\item\ItemController::class, 'createItem']);

        });
    }
}
