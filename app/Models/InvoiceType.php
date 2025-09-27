<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function invoices()
    {
        return $this->hasMany(SalesInvoice::class);
    }
}
