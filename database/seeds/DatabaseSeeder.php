<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\Batch::class, 100)->create();
        factory(App\DrugType::class, 5)->create();
        factory(App\GenericName::class, 21)->create();
        factory(App\Manufacturer::class, 27)->create();
        factory(App\Product::class, 22)->create();
        factory(App\Supplier::class, 5)->create();
        factory(App\Inventory::class, 500)->create();
        factory(App\Sale::class, 250)->create();
        factory(App\ProductSale::class, 1000)->create();
        factory(App\Customer::class, 20)->create();
        factory(App\User::class)->create();
    }
}
