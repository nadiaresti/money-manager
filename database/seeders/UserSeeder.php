<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'superuser',
            'name' => 'superuser',
            'email' => 'superuser@xxx.xx',
            'password' => Hash::make('superuser'),
            'role' => User::ROLE_SUPERUSER,
        ]);
    }
}
