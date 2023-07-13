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

    public function getAllInvoices()
    {
        try {
            $invoices = $this->invoice->with('author', 'items')->get();

            foreach ($invoices as $invoice) {
                $total = 0;
                foreach ($invoice->items as $item) {
                    $total += $item->price;
                }
                $invoice->total = $total;
            }
            return response()->json(['success' => true, 'invoices' => $invoices]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
    public function getByIdInvoice($id)
    {
        try {
            $invoice = $this->invoice->with('author.address', 'items')->where('id', $id)->first();

            $totalPrice = 0;
            foreach ($invoice->items as $item) {
                $item->totalItem = $item->qty * $item->price;
                $totalPrice += $item->totalItem;
            }
            $invoice->totalPrice = number_format($totalPrice, 2);

            return response()->json(['success' => true, 'invoice' => $invoice]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
}
