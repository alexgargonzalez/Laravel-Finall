<?php

namespace Database\Seeders;

use App\Models\Pelo;
use App\Models\Peinado;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeinadoSeeder extends Seeder {
    
    public function run(): void {
        $faker = Factory::create();
        for ($i=0; $i < 2; $i++) { 
           $author = $faker->firstName();
           $name = $faker->unique()->word() . ' ' . $faker->unique()->word();
           $ids = Pelo::pluck('id');
           $ids = $ids->all();
           $position = array_rand($ids);
           $peinado = new Peinado();
           $peinado->author = $author;
           $peinado->name = $name;
           $peinado->idpelo = $ids[$position];
           $peinado->iduser = 1;
           $peinado->description = $faker->sentence(10);
           $peinado->price = rand(5, 9500)/100;
           $peinado->save();
        }
    }
}
