<?php

namespace App\Http\Controllers\invoice;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\SendersAddress;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $client, $address, $sender_address, $invoice, $item;

    public function __construct(Client $client, Address $address, Invoice $invoices, SendersAddress $sender_address, Item $items)
    {
        $this->client = $client;
        $this->address = $address;
        $this->sender_address = $sender_address;
        $this->invoice = $invoices;
        $this->item = $items;
    }

    public function getAllInvoices()
    {
        try {
            $invoices = $this->invoice->whereHas('items')->whereHas('sender')->with('author', 'items', 'sender')->get();

            foreach ($invoices as $invoice) {
                $total = 0;
                foreach ($invoice->items as $item) {
                    $total += $total += $item->qty * $item->price;
                }
                $invoice->total = (float)number_format($total, 2, '.', '');
            }
            return response()->json(['success' => true, 'invoices' => $invoices]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }

    public function getByIdInvoice($id)
    {
        try {
            $invoice = $this->invoice->with('author', 'sender', 'author.address', 'items')->where('id', $id)->first();

            $totalPrice = 0;
            foreach ($invoice->items as $item) {
                $item->totalItem = $item->qty * $item->price;
                $totalPrice += $item->totalItem;
            }
            $invoice->totalPrice = (float) number_format($totalPrice, 2, '.', '');
            $formattedInvoice = [
                'senderAddress' => [
                    'street' => $invoice->sender->street,
                    'city' => $invoice->sender->city,
                    'postCode' => $invoice->sender->cep,
                    'country' => $invoice->sender->country,
                ],
                'clientName' => $invoice->author->name,
                'clientEmail' => $invoice->author->email,
                'clientAddress' => [
                    'street' => $invoice->author->address->street,
                    'city' => $invoice->author->address->city,
                    'postCode' => $invoice->author->address->cep,
                    'country' => $invoice->author->address->country,
                ],
                'createdAt' => $invoice->created_at,
                'paymentTerms' => $invoice->payment_terms,
                'description' => $invoice->description,
                'status' => $invoice->status,
                'items' => [],
            ];

            foreach ($invoice->items as $item) {
                $formattedItem = [
                    'name' => $item->name,
                    'description' => $item->description,
                    'quantity' => $item->qty,
                    'price' => $item->price,
                    'totalItem' => $item->qty * $item->price,
                ];
                $formattedInvoice['items'][] = $formattedItem;
            }

            return response()->json(['success' => true, 'invoice' => $formattedInvoice]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }

    public function saveInvoice(Request $request)
    {
        try {

            $client = new Client();
            $client->name = $request->input('clientName');
            $client->email = $request->input('clientEmail');
            $client->save();

            $invoice = new Invoice();
            $invoice->description = $request->input('description');
            $invoice->payment_terms = $request->input('paymentTerms');
            $invoice->created_at = $request->input('createdAt');
            $invoice->id_client = $client->id;
            $invoice->save();

            $clientAddressData = $request->input('clientAddress');
            $clientAddress = new Address();
            $clientAddress->street = $clientAddressData['street'];
            $clientAddress->city = $clientAddressData['city'];
            $clientAddress->cep = $clientAddressData['postCode'];
            $clientAddress->country = $clientAddressData['country'];
            $clientAddress->id_client = $client->id;
            $clientAddress->save();

            $senderAddressData = $request->input('senderAddress');
            $senderAddress = new SendersAddress();
            $senderAddress->street = $senderAddressData['street'];
            $senderAddress->city = $senderAddressData['city'];
            $senderAddress->cep = $senderAddressData['postCode'];
            $senderAddress->country = $senderAddressData['country'];
            $senderAddress->save();


            $itemsData = $request['items'];
            foreach ($itemsData as $itemData) {
                $item = new Item();
                $item->name = $itemData['name'];
                $item->price = $itemData['price'];
                $item->qty = $itemData['quantity'];
                $item->id_invoice = $invoice->id;
                $item->save();
            }

            return response()->json(['success' => true, 'message' => 'Invoice saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error saving invoice: ' . $e->getMessage()]);
        }
    }

    public function updateInvoice(Request $request, $id)
    {
        try {

            $invoice = $this->invoice->find($id);

            if (!$invoice) {
                return response()->json(['success' => false, 'message' => 'Invoice not found']);
            }

            $client = $this->client->find($invoice->id_client);

            if (!$client) {
                return response()->json(['success' => false, 'message' => 'Client not found']);
            }

            $client->update([
                'name' => $request->input('clientName'),
                'email' => $request->input('clientEmail'),
            ]);

            $invoice->update([
                'description' => $request->input('description'),
                'payment_terms' => $request->input('paymentTerms'),
                'created_at' => $request->input('createdAt'),
                'id_client' => $client->id,
            ]);

            $clientAddressData = $request->input('clientAddress');
            $clientAddress = $this->address->find($clientAddressData['id']);
            $clientAddress->update([
                'street' => $clientAddressData['street'],
                'city' => $clientAddressData['city'],
                'cep' => $clientAddressData['postCode'],
                'country' => $clientAddressData['country'],
                'id_client' => $client->id,
            ]);

            $senderAddressData = $request->input('senderAddress');
            $senderAddress = $this->sender_address->find($senderAddressData['id']);
            $senderAddress->update([
                'street' => $senderAddressData['street'],
                'city' => $senderAddressData['city'],
                'cep' => $senderAddressData['postCode'],
                'country' => $senderAddressData['country'],
            ]);

            $itemsData = $request->input('items');
            foreach ($itemsData as $itemData) {
                $item = $this->items->find($itemData['id']);
                $item->update([
                    'name' => $itemData['name'],
                    'price' => $itemData['price'],
                    'qty' => $itemData['quantity'],
                ]);
            }


            return response()->json(['success' => true, 'message' => 'Invoice updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error saving invoice: ' . $e->getMessage()]);
        }
    }
    public function deleteInvoice($id)
    {
        try {
            $invoice = $this->invoice->find($id);

            if (!$invoice) {
                return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
            }

            $invoice->delete();

            return response()->json(['success' => true, 'message' => 'Invoice deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error saving invoice: ' . $e->getMessage()]);
        }
    }
    public function markAsPaid($id)
    {
        try {
            $invoice = $this->invoice->find($id);

            if (!$invoice) {
                return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
            }
            $invoice->status = 'Paid';
            $invoice->save();

            return response()->json(['success' => true, 'message' => 'Invoice marked as paid']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error saving invoice: ' . $e->getMessage()]);
        }
    }
}
