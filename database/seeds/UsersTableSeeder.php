<?php

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
        factory(App\Models\User::class)->create([
            'name' => 'Michael Bonner',
            'email' => 'info@fictiveweb.com',
            'password' => bcrypt('secret'),
        ]);
        factory(App\Models\User::class)->create();
    }
}
