<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;

class Invoice
{
    public static function routesInvoice($middlware = [], $prefix = '')
    {
        return Route::group(['middleware' => $middlware, 'prefix' => $prefix], function () {
            Route::get('/invoices', [\App\Http\Controllers\invoice\InvoiceController::class, 'getAllInvoices']);
//            Route::post('/enviar-criar-editar-lembrete', [\App\Http\Controllers\agenda\AgendaFamiliaController::class, 'criarEditarLembrete']);
//            Route::post('/enviar-apagar-lembrete', [\App\Http\Controllers\agenda\AgendaFamiliaController::class, 'criarEditarLembrete']);
        });
    }
}
