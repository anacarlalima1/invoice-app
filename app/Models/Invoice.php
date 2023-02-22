<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    protected $table = 'invoices';
    use HasFactory;
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'id_item', 'id');
    }

    public function listInvoices($request)
    {
        return DB::table('invoices')
            ->leftJoin('clients', 'clients.id', '=', 'invoices.id_client')
            ->leftJoin('addresses', 'addresses.id_client', '=', 'clients.id')
            ->leftJoin('items', 'items.id', '=', 'invoices.id_item')
            ->select('invoices.*', 'clients.name', 'clients.email', 'addresses.city', 'addresses.country', 'addresses.street', 'items.name as item', 'items.price', 'items.qty')
            ->where(function ($query) use ($request) {
                if (isset($request['status'])) {
                    $query->whereIn('invoices.status', $request['status']);
                }
            })
            ->paginate(10);
    }
}
