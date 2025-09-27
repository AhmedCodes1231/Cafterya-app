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
       /*Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // من عمل الفاتورة
            $table->foreignId('invoice_type_id')->constrained('invoice_types')->onDelete('cascade');
            $table->decimal('total', 10, 2)->default(0);
            $table->string('invoice_number', 255)->nullable()->after('id');
            $table->timestamps();
        });*/
        /*Schema::create('sales_invoices', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number', 255)->nullable(); // رقم الفاتورة
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('invoice_type_id')->constrained('invoice_types')->onDelete('cascade');
    $table->decimal('total_amount', 10, 2)->default(0); // اسم الحقل يجب أن يكون total_amount حسب الكود
    $table->string('customer_name')->nullable();
    $table->string('status')->default('completed');
    $table->timestamps();
});*/
Schema::create('sales_invoices', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number', 255)->nullable();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('invoice_type_id')->constrained('invoice_types')->onDelete('cascade');
    $table->decimal('total_amount', 10, 2)->default(0);
    $table->decimal('discount', 10, 2)->default(0); // أضف هذا السطر
    $table->decimal('paid_amount', 10, 2)->default(0); // أضف هذا السطر
    $table->string('customer_name')->nullable();
    $table->string('status')->default('completed');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoices');
    }
};


/*
Schema::create('sales_invoices', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('invoice_type_id')->constrained();
    $table->decimal('total', 12, 2);
    $table->text('addons')->nullable();
    $table->timestamps();
});
*/
