<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create categories (idempotent)
        $electronics = Category::firstOrCreate([
            'name' => 'Electronics'
        ], [
            'description' => 'Electronic devices and gadgets',
        ]);

        $furniture = Category::firstOrCreate([
            'name' => 'Furniture'
        ], [
            'description' => 'Office and home furniture',
        ]);

        $clothing = Category::firstOrCreate([
            'name' => 'Clothing'
        ], [
            'description' => 'Men and women clothing',
        ]);

        // Create or update products
        $laptop = Product::updateOrCreate([
            'sku' => 'DELL-XPS-13'
        ], [
            'name' => 'Laptop Dell XPS 13',
            'description' => 'High performance laptop with 13 inch display',
            'category_id' => $electronics->id,
            'price' => 1299.99,
            'quantity' => 5,
            'minimum_stock' => 2,
        ]);

        $mouse = Product::updateOrCreate([
            'sku' => 'LOGI-MOUSE-01'
        ], [
            'name' => 'Wireless Mouse Logitech',
            'description' => 'Ergonomic wireless mouse',
            'category_id' => $electronics->id,
            'price' => 49.99,
            'quantity' => 15,
            'minimum_stock' => 5,
        ]);

        $chair = Product::updateOrCreate([
            'sku' => 'CHAIR-PRO-01'
        ], [
            'name' => 'Office Chair Pro',
            'description' => 'Comfortable office chair with lumbar support',
            'category_id' => $furniture->id,
            'price' => 299.99,
            'quantity' => 8,
            'minimum_stock' => 3,
        ]);

        $tshirt = Product::updateOrCreate([
            'sku' => 'TSHIRT-BLUE-M'
        ], [
            'name' => 'Cotton T-Shirt Blue',
            'description' => 'Premium cotton t-shirt',
            'category_id' => $clothing->id,
            'price' => 19.99,
            'quantity' => 2,
            'minimum_stock' => 10,
        ]);

        $keyboard = Product::updateOrCreate([
            'sku' => 'KB-RGB-MECH'
        ], [
            'name' => 'Mechanical Keyboard RGB',
            'description' => 'Gaming mechanical keyboard with RGB lighting',
            'category_id' => $electronics->id,
            'price' => 129.99,
            'quantity' => 0,
            'minimum_stock' => 3,
        ]);

        // Create stock movements if they do not exist
        StockMovement::firstOrCreate([
            'product_id' => $laptop->id,
            'type' => 'in',
            'quantity' => 10,
            'reference' => 'PO-001',
        ], [
            'notes' => 'Initial stock',
        ]);

        StockMovement::firstOrCreate([
            'product_id' => $mouse->id,
            'type' => 'in',
            'quantity' => 20,
            'reference' => 'PO-002',
        ], [
            'notes' => 'Stock replenishment',
        ]);

        // Create users if not exists
        User::firstOrCreate([
            'email' => 'admin@inventory.com',
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'role_text' => 'admin',
        ]);

        User::firstOrCreate([
            'email' => 'cashier@inventory.com',
        ], [
            'name' => 'Cashier User',
            'password' => bcrypt('cashier123'),
            'role' => 'cashier',
            'role_text' => 'cashier',
        ]);

        // Create gudang (warehouse) user
        User::firstOrCreate([
            'email' => 'gudang@inventory.com',
        ], [
            'name' => 'Gudang User',
            'password' => bcrypt('gudang123'),
            'role_text' => 'gudang',
        ]);
    }
}
