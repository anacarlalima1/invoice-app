<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Address extends Model
{
    protected $table = 'addresses';
    use HasFactory;
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id');
    }

    public function getAddressInfos()
    {
        return DB::table('addresses')
            ->leftJoin('clients', 'clients.id', '=', 'addresses.id_client')
            ->select('addresses.*', 'clients.name', 'clients.email')
            ->paginate(10);
    }
}
