<?php

namespace App\Http\Controllers\invoice;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Item;
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
                    $total += $total += $item->qty * $item->price;
                }
                $invoice->total = number_format($total, 2);
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
    public function saveInvoice(Request $request)
    {

        $client = new Client();
        $client->name = $request->input('clientName');
        $client->email = $request->input('clientEmail');
        $client->save();

        $invoice = new Invoice();
        $invoice->description = $request->input('description');
        $invoice->data_payment = $request->input('paymentTerms');
        $invoice->created_at = $request->input('createdAt');

        $clientAddress = new Address();
        $clientAddress->street = $request->input('street');
        $clientAddress->city = $request->input('city');
        $clientAddress->cep = $request->input('postCode');
        $clientAddress->country = $request->input('country');
        $clientAddress->id_client = $client->id;
        $clientAddress->save();


        // Salve os itens da invoice
        $itemsData = $request->input('items');
        foreach ($itemsData as $itemData) {
            $item = new Item();
            $item->name = $itemData['name'];
            $item->price = $itemData['price'];
            $item->qty = $itemData['quantity'];
            $item->id_invoice = $invoice->id;
            $item->save();
        }

        // Associe o cliente à invoice
        $invoice->id_client = $client->id;

        // Salve a invoice
        $invoice->create();
//        $client = $this->client->create([
//            'name' => $request->input('clientName'),
//            'email' => $request->input('clientEmail'),
//        ]);
//
//        // Crie um novo objeto Invoice
////        $invoice = new Invoice();
//
//        // Preencha os campos da invoice com base nos dados recebidos do request
//        $invoice = $this->invoice->create([
//            'description' => $request->input('description'),
//            'data_payment' => $request->input('paymentTerms'),
//            'created_at' => $request->input('createdAt'),
//            'id_client' => $client->id,
//        ]);
//
//        // Salve o endereço do cliente
//        $clientAddressData = $this->address->create([
//            'street' => $request->input('street'),
//            'city' => $request->input('city'),
//            'cep' => $request->input('postCode'),
//            'country' => $request->input('country'),
//        ]);
//        $itemsData = $request->input('items');
//        foreach ($itemsData as $itemData) {
//            $item = new Item();
//            $item->name = $itemData['name'];
//            $item->price = $itemData['price'];
//            $item->qty = $itemData['quantity'];
//            $item->id_invoice = $invoice->id;
//            $item->save();
//        }
//
//
////        // Salve o endereço do remetente
////        $senderAddressData = $request->input('senderAddress');
////        $senderAddress = new Address();
////        $senderAddress->street = $senderAddressData['street'];
////        $senderAddress->city = $senderAddressData['city'];
////        $senderAddress->cep = $senderAddressData['postCode'];
////        $senderAddress->country = $senderAddressData['country'];
////        $senderAddress->save();
//
//        // Salve os itens da invoice
//        $itemsData = $request->input('items');
//        foreach ($itemsData as $itemData) {
//            $item = new Item();
//            $item->name = $itemData['name'];
//            $item->price = $itemData['price'];
//            $item->qty = $itemData['quantity'];
//            $item->id_invoice = $invoice->id;
//            $item->save();
//        }
//
//        // Associe o cliente à invoice
//        $invoice->id_client = $client->id;
//
//        // Salve a invoice
//        $invoice->save();

        // Retorne uma resposta de sucesso
        return response()->json(['success' => true, 'message' => 'Invoice saved successfully']);
    }
}
