<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin' ,
            'email' => 'admin@admin.com' ,
            'password' => Hash::make('administrador1'),
        ]);

        $user->assignRole('super-admin');
    }
}
