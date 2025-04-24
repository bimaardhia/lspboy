<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{

    use HasFactory;

    protected $fillable = [
        'total',
        'paid_amount',
        'change'
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

}