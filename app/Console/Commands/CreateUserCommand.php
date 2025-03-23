<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {password?} {--team= : The name of the team to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password') ?? Str::random(10);
        $teamName = $this->option('team');

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");
            return 1;
        }

        // Create the user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Create personal team
        $personalTeam = Team::forceCreate([
            'user_id' => $user->id,
            'name' => $user->name . "'s Team",
            'personal_team' => true,
        ]);

        // Save the personal team and switch to it
        $user->ownedTeams()->save($personalTeam);
        $user->switchTeam($personalTeam);

        // Create additional team if specified
        if ($teamName) {
            $team = Team::forceCreate([
                'user_id' => $user->id,
                'name' => $teamName,
                'personal_team' => false,
            ]);
            $user->ownedTeams()->save($team);
            $user->switchTeam($team);
        }



        $this->info("User created successfully!");
        $this->info("Name: {$name}");
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");

        if ($teamName) {
            $this->info("Team: {$teamName}");
        }

        return 0;
    }
}
