<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function author()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice', 'id');
    }

}
