<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Generator;
use Faker\Factory as Faker;
use Carbon\Carbon;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 1000 ; $i++) {
            $faker = app(Generator::class);
            DB::table('productos')->insert([
                'name' => $faker->word,
                'precio' => $faker->numberBetween($min = 10, $max = 100),
                'stock' => $faker->numberBetween($min = 5, $max = 50),
                'categoria_id' => 3,
                'sucursal_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
       }
    }
}
