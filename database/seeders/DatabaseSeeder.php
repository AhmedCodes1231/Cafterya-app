<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    \App\Models\Role::factory(3)->create();
    \App\Models\User::factory(10)->create();
    \App\Models\UserRole::factory(10)->create();
    \App\Models\Category::factory(4)->create();
    \App\Models\Item::factory(10)->create();
    \App\Models\InvoiceType::factory(3)->create();
    \App\Models\SalesInvoice::factory(10)->create();
    \App\Models\SalesInvoiceDetail::factory(20)->create();
    \App\Models\CafeteriaInfo::factory(1)->create();
    }
}
