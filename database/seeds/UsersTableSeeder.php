<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ardi Chris',
            'email' => 'ardi.chris@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('b3nt3ng'),
            'role' => 0
        ]);
    }
}