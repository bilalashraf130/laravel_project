<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class UserNarrativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $users = User::pluck('id')->toArray();
        $startDate = Carbon::createFromDate(2020, 1, 1);
        $endDate = Carbon::createFromDate(2023, 1, 1);

// Loop through each month between the start and end dates
        for ($date = $startDate; $date->lessThan($endDate); $date->addMonth()) {
            foreach ($users as $user) {
                for ($i = 0; $i < 2; $i++) {
                    $createdAt = $faker->dateTimeBetween('2020-01-01', '2023-01-01');
                    $updatedAt = $faker->dateTimeBetween($createdAt, 'now');

                    DB::table('user_narrative')->insert([
                        'user_id' => $user,
                        'narrative' => $faker->paragraph,
                        'whats_on_your_mind' => $faker->sentence(10),
                        'thought_concern' => $faker->sentence(6),
                        'your_hope' => $faker->sentence(8),
                        'status' => 'free',
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt,
                    ]);
                }
            }
        }
    }
//    public function run()
//    {
//        $faker = Faker::create();
//        $users = User::pluck('id')->toArray();
//        $currentMonth = null;
//        $count = 0;
//
//        for ($i = 0; $i < 24; $i++) {
//            $createdAt = $faker->dateTimeBetween('2020-01-01', '2023-01-01');
//            $updatedAt = $faker->dateTimeBetween($createdAt, 'now');
//            $date = Carbon::instance($createdAt);
//
//            if (!$currentMonth || $date->month !== $currentMonth) {
//                $currentMonth = $date->month;
//                $count = 0;
//            }
//
//            if ($count < 2) {
//                DB::table('user_narrative')->insert([
//                    'user_id' => $faker->randomElement($users),
//                    'narrative' => $faker->paragraph,
//                    'whats_on_your_mind' => $faker->sentence(10),
//                    'thought_concern' => $faker->sentence(6),
//                    'your_hope' => $faker->sentence(8),
//                    'status' => 'free',
//                    'created_at' => $createdAt,
//                    'updated_at' => $updatedAt,
//                ]);
//
//                $count++;
//            }
//        }
//    }

}
