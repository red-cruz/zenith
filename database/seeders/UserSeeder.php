<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(3)
          ->has(Shop::factory()->hasShopAddress())
          ->hasUserAddresses(2)
          ->create();
    }
}
