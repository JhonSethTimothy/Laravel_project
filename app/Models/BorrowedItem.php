<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'borrower_name',
        'equipment_name',
        'equipment_quantity',
        'product_name',
        'product_quantity',
        'location',
        'purpose',
        'borrowed_time',
        'returned_item',
        'quantity_returned',
        'returned_time',
        'person_in_charge',
        'remarks',
        'sent_to_admin',
    ];
}
