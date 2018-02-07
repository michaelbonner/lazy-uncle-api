<?php

use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\Models\User::latest()->first();
        factory(App\Models\Person::class, 5)->create(['user_id'=>$user->id]);
    }
}
