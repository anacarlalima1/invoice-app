<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "clients";
    protected $fillable = ['name', 'email'];

    use HasFactory;
    public function address()
    {
        return $this->hasOne(Address::class, 'id_client', 'id');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'id_client', 'id');
    }

}
