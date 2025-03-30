<?php

namespace App\Console\Commands;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--u|username= : Username of the newly created user.} {--e|email= : E-Mail of the newly created user.} {--p|password : Manual password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually creates a new laravel user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Enter username, if not present via command line option
        $name = $this->option('username');
        if ($name === null) {
            $name = $this->ask('Username');
        }

        // Enter email, if not present via command line option
        $email = $this->option('email');
        if ($email === null) {
            $email = $this->ask('E-Mail');
        }

        // $email = $this->option('companyId');
        // if ($email === null) {
        $companyID = $this->ask('Company ID');
        // }

        $hasPasswordOption = $this->option('password');
        $this->info($hasPasswordOption);
        if (!$hasPasswordOption) {
            $password = Str::password();
        }
        else {
            $password = $this->secret('Please enter a new password.');
        }

        try {
            $user = new User();
            $user->password = Hash::make($password);
            $user->email = $email;
            $user->name = $name;
            $user->company_id = $companyID;
            $user->save();
        }
        catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        // Success message
        $this->info('User created successfully!');
        $this->info('New user ID: ' . $user->id);
        if (!$this->option('password')) {
            $this->info('Auto-generated password ' . $password);
            $this->info('USER WILL GET PASSWORD RESET LINK ON THEIR EMAIL');
            $status = Password::sendResetLink(
                ['email' => $email]
            );
    
            if ($status != Password::RESET_LINK_SENT) {
                $this->addError($email, __($status));
    
                return;
            }
            session()->flash('status', __($status));
        }
    }
}
