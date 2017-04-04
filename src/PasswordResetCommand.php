<?php

namespace JoePriest\PasswordReset;

use App\User;
use Illuminate\Console\Command;

class PasswordResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:resetpassword {user? : The ID of the user  (You will be prompted to choose a user if you don\'t provide an ID)} {password? : Optionally choose a new password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the given users password';

    protected $passwordField;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->searchField = config('passwordreset.search_field');
        $this->passwordField = config('passwordreset.password_field');

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->comment('passwordField from config: '.$this->passwordField);

        // If no user ID was provided, search for a user instead
        if ( !$user = User::find($this->argument('user')) ){

            // Get user search field into an array formatted for suggestions
            $users = User::select($this->searchField)->get()->pluck($this->searchField)->all();

            $searchResult = $this->anticipate('Which user\'s password would you like to reset?', $users);

            $user = User::where($this->searchField, $searchResult)->first();

        }

        // If no password was provided, ask for one or generate a random one
        if ( !$password = $this->argument('password') ){

            $randomPassword = str_random(14);

            $password = $this->ask("What should the new password be for {$user->{$this->searchField}}? Leave blank to use the following:", $randomPassword);

        }

        $this->comment("Resetting password for {$user->{$this->searchField}}...");

        $user->{$this->passwordField} = bcrypt($password);

        $user->save();

        $this->info("Password reset successfully! New password is: {$password}");

    }
}
