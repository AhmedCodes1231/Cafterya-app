<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {


      Schema::create('sales_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained('sales_invoices')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2); // سعر الصنف عند إصدار الفاتورة
            $table->decimal('total', 10, 2); // سعر × كمية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_details');
    }
};


/*Schema::create('sales_invoice_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sales_invoice_id')->constrained()->cascadeOnDelete();
    $table->foreignId('item_id')->constrained();
    $table->integer('quantity');
    $table->decimal('price', 10, 2);
    $table->decimal('total', 12, 2);
    $table->timestamps();
});*/
