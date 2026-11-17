<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email?} {--name=}';

    protected $description = 'Create or promote an administrator account';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Admin email');
        $name = $this->option('name') ?: $this->ask('Admin name', 'System Administrator');
        $password = $this->secret('Admin password');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen((string) $password) < 12) {
            $this->error('Use a valid email and a password of at least 12 characters.');

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ],
        );

        $this->info("Administrator account ready: {$email}");

        return self::SUCCESS;
    }
}
