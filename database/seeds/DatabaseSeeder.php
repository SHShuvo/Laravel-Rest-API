<?php

use App\Model\Product;
use App\Model\Review;
use App\User;
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
        factory(User::class,5)->create();
        factory(Product::class,50)->create();
        factory(Review::class,150)->create();
    }
}
