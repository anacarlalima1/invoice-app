<?php

namespace App\Http\Controllers\invoice;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $client;

    public function __construct(Client $client, Address $address, Invoice $invoices)
    {
        $this->client = $client;
        $this->address = $address;
        $this->invoice = $invoices;
    }

    public function getAllInvoices(Request $request)
    {
        try {
            return response()->json(['success' => true, 'invoices' => $this->invoice->listInvoices($request)]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
    public function getByIdInvoice($id)
    {
        try {
            return response()->json(['success' => true, 'invoice' => $this->invoice->listInvoices($id)]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
}
