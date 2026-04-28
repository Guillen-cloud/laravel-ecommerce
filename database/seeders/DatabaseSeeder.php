<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'customer'],
        ]);

        DB::table('users')->insert([
            'name' => 'Admin Ecommerce',
            'email' => 'admin@ecommerce.test',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
        ]);

        DB::table('payment_methods')->insert([
            ['name' => 'cash'],
            ['name' => 'qr'],
            ['name' => 'card'],
        ]);

        DB::table('order_statuses')->insert([
            ['name' => 'pending'],
            ['name' => 'paid'],
            ['name' => 'shipped'],
            ['name' => 'delivered'],
            ['name' => 'cancelled'],
        ]);

        DB::table('brands')->insert([
            ['name' => 'Samsung'],
            ['name' => 'Apple'],
            ['name' => 'Sony'],
        ]);

        DB::table('industries')->insert([
            ['name' => 'Technology'],
            ['name' => 'Appliances'],
        ]);

        DB::table('categories')->insert([
            ['name' => 'Smartphones'],
            ['name' => 'Laptops'],
        ]);

        DB::table('products')->insert([
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Smartphone 128GB',
                'price' => 899.99,
                'brand_id' => 1,
                'industry_id' => 1,
                'category_id' => 1,
                'status' => 'available',
            ],
            [
                'name' => 'MacBook Air M3',
                'description' => 'Apple Laptop',
                'price' => 1299.99,
                'brand_id' => 2,
                'industry_id' => 1,
                'category_id' => 2,
                'status' => 'available',
            ],
        ]);

        DB::table('branches')->insert([
            [
                'name' => 'Main Branch',
                'address' => 'Central Ave 123',
                'phone' => '111111',
            ],
        ]);

        DB::table('product_branch')->insert([
            ['product_id' => 1, 'branch_id' => 1, 'stock' => 20],
            ['product_id' => 2, 'branch_id' => 1, 'stock' => 10],
        ]);
    }
}
