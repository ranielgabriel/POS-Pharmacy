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
        factory(App\Inventory::class, 50)->create();
        factory(App\Customer::class, 10)->create();
        factory(App\User::class)->create();
    }
}
