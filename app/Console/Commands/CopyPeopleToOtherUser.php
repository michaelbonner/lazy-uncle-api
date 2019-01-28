<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CopyPeopleToOtherUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:people';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy people from one user to another';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentUserEmail = $this->ask('What is the email of the current user?');
        if (!$currentUser = User::where('email', $currentUserEmail)->first()) {
            $this->error('No user with that email');
            die;
        }
        
        $newUserEmail = $this->ask('What is the email of the new user?');
        if (!$newUser = User::where('email', $newUserEmail)->first()) {
            $this->error('No user with that email');
            die;
        }

        $this->line('Copying people over');
        $currentPeople = $currentUser->people->each(function ($person) use ($newUser) {
            $newUser->people()->updateOrCreate([
                'user_id' => $newUser->id,
                'name' => $person->name,
                'birthday' => $person->birthday,
                'parent' => $person->parent,
            ]);
        });
        $this->info('Finished');
    }
}
