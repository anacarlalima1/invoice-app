<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = ['description', 'data_payment', 'id_client', 'created_at'];
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'id_invoice', 'id');
    }
}
