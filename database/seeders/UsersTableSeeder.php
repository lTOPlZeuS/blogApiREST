<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciar la tabla
        User::truncate();
        $faker = \Faker\Factory::create();
        // Crear la misma clave para todos los usuarios
        // conviene hacerlo antes del for para que el seeder
        // no se vuelva lento.
        $password = Hash::make('123123');
        $user = User::create(['name'=> 'Administrador','email'=> 'admin@prueba.com','password'=> $password,]);
        // Generar algunos usuarios para nuestra aplicacion
        for($i = 0; $i < 10; $i++) {
            User::create(['name'=> $faker->name,'email'=> $faker->email,'password'=> $password,]);
            $user->categories()->saveMany(
                $faker->randomElements(
                    array(
                        Category::find(1),
                        Category::find(2),
                        Category::find(3)
                    ), $faker->numberBetween(1, 3), false));
         }
    }
}
