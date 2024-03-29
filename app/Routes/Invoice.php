<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;

class Invoice
{
    public static function routesInvoice($middlware = [], $prefix = '')
    {
        return Route::group(['middleware' => $middlware, 'prefix' => $prefix], function () {
            Route::get('/invoices', [\App\Http\Controllers\invoice\InvoiceController::class, 'getAllInvoices']);
            Route::get('/invoices/{id}', [\App\Http\Controllers\invoice\InvoiceController::class, 'getByIdInvoice']);
            Route::post('/invoices', [\App\Http\Controllers\invoice\InvoiceController::class, 'saveInvoice']);
            Route::put('/invoices/{id}', [\App\Http\Controllers\invoice\InvoiceController::class, 'updateInvoice']);
            Route::patch('/invoices/mark-as-paid/{id}', [\App\Http\Controllers\invoice\InvoiceController::class, 'markAsPaid']);
            Route::delete('/invoices/{id}', [\App\Http\Controllers\invoice\InvoiceController::class, 'deleteInvoice']);
        });
    }
}
