<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'Jean-Philippe Murray',
            'email' => 'curieuxmurray@gmail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
