<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SendersAddress extends Model
{
    protected $table = 'senders_address';
    protected $fillable = ['street', 'city', 'country', 'cep'];

    use HasFactory;
}
