<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

final class CreateAdminUserCommand extends Command
{
    protected $signature = 'app:create-admin-user
        {--name= : Admin user name}
        {--email= : Admin user email}
        {--password= : Admin user password}';

    protected $description = 'Create or update an admin user for the Filament panel.';

    public function handle(): int
    {
        $name = $this->option('name') ?: $this->ask('Name', 'Admin');
        $email = $this->option('email') ?: $this->ask('Email', 'admin@example.com');
        $password = $this->option('password') ?: $this->secret('Password');

        if (!is_string($name) || trim($name) === '') {
            $this->error('Name is required.');

            return self::FAILURE;
        }

        if (!is_string($email) || trim($email) === '') {
            $this->error('Email is required.');

            return self::FAILURE;
        }

        if (!is_string($password) || trim($password) === '') {
            $this->error('Password is required.');

            return self::FAILURE;
        }

        $validator = Validator::make(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ],
        );

        $this->info($user->wasRecentlyCreated
            ? 'Admin user created successfully.'
            : 'Admin user updated successfully.'
        );

        $this->line('Email: ' . $email);

        return self::SUCCESS;
    }
}
