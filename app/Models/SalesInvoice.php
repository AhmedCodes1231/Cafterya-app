<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesInvoice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'invoice_type_id', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function items()
{
    return $this->hasMany(SalesInvoiceDetail::class, 'sales_invoice_id');
}

    public function type()
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type_id');
    }

    public function details()
    {
        return $this->hasMany(SalesInvoiceDetail::class, 'invoice_id');
    }
}
