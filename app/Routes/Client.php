<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;

class Client
{
    public static function routesClient($middlware = [], $prefix = '')
    {
        return Route::group(['middleware' => $middlware, 'prefix' => $prefix], function () {
            Route::get('/clients', [\App\Http\Controllers\client\ClientController::class, 'getAllClients']);
//            Route::post('/enviar-criar-editar-lembrete', [\App\Http\Controllers\agenda\AgendaFamiliaController::class, 'criarEditarLembrete']);
//            Route::post('/enviar-apagar-lembrete', [\App\Http\Controllers\agenda\AgendaFamiliaController::class, 'criarEditarLembrete']);
        });
    }
}
