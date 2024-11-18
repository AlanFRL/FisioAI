<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Milenka Rojas',
            'email' => 'milenka@gmail.com',
            'password' => Hash::make('1234'),
            'fecha_nacimiento' => '2001-05-31', // Fecha de nacimiento fija
        ]);

        User::create([
            'name' => 'Alan Romero',
            'email' => 'alan@gmail.com',
            'password' => Hash::make('1234'),
            'fecha_nacimiento' => '2000-06-27', // Fecha de nacimiento fija
        ]);

        User::create([
            'name' => 'Pablo Castedo',
            'email' => 'pablo@gmail.com',
            'password' => Hash::make('1234'),
            'fecha_nacimiento' => '1999-09-10', // Fecha de nacimiento fija
        ]);
    
    }
}
