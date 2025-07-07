<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'client',
        'location',
        'purpose',
        'item_description',
        'quantity',
        'person_in_charge',
        'remarks',
        'sent_to_admin',
    ];
}
