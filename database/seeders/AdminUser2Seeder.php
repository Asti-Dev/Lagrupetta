<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUser2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin2' ,
            'email' => 'daniela@quesito.pe' ,
            'password' => Hash::make('administrador2'),
        ]);

        $user->assignRole('super-admin');
    }
}
