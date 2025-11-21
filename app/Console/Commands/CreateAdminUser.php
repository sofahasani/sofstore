<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin {email} {password} {name?}';
    protected $description = 'Create a new admin user';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->argument('name') ?? 'Admin';

        if (User::where('email', $email)->exists()) {
            $this->error('❌ User with this email already exists!');
            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->info('✅ Admin user created successfully!');
        $this->info("📧 Email: {$email}");
        $this->info("🔑 Password: {$password}");
        $this->info("👤 Name: {$name}");

        return 0;
    }
}
