<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    protected $table = "clients";

    use HasFactory;
    public function address()
    {
        return $this->hasOne(Address::class, 'id_client', 'id');
    }
    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'id_client', 'id');
    }
}
