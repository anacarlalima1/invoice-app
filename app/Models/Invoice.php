<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = ['description', 'payment_terms', 'id_client', 'created_at'];
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'id_invoice', 'id');
    }
    public function sender()
    {
        return $this->hasOne(SendersAddress::class, 'id_invoice', 'id');
    }
}
