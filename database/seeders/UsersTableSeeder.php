<?php

namespace Database\Seeders;

use App\Models\User;
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
        factory(User::class)->create([
            'name' => 'Michael Bonner',
            'email' => 'info@fictiveweb.com',
            'password' => bcrypt('secret'),
        ]);
        factory(User::class)->create();
    }
}
