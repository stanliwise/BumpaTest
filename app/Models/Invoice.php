<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
