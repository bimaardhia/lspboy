<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'total',
        'paid_amount',
        'change'
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}