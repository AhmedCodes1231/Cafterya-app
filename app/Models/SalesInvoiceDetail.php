<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesInvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'item_id', 'quantity', 'price', 'total'];

    public function invoice()
{
    return $this->belongsTo(SalesInvoice::class, 'sales_invoice_id');
}
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
