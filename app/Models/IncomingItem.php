<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'serial_number',
        'model',
        'brand',
        'item_description',
        'quantity',
        'remarks',
        'sent_to_admin',
    ];
}
