<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker = Faker::create();

           for($i=5;$i<=50000;$i++){
           DB::table('users')->insert([
               'name' => $faker->name(),
               'email'=> $faker->unique()->safeEmail(),
               'password'=> $faker->password(),
           ]);

       }
    }
}
