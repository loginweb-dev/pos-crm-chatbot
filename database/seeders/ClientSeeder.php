<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Generator;
use Faker\Factory as Faker;
use Carbon\Carbon;
class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       for ($i=0; $i < 100 ; $i++) {
            $faker = app(Generator::class);
            $name = $faker->firstName();
            $last = $faker->lastName();
            DB::table('clientes')->insert([
                'first_name' => $name,
                'last_name' => $last,
                'display' => $name.' '.$last,
                'phone' => $faker->phoneNumber,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
       }

    }
}
