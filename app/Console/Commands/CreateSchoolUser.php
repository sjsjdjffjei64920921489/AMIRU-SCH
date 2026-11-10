<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CreateSchoolUser extends Command
{
    protected $signature = 'school:user';

    protected $description = 'Create a staff or student portal account';

    public function handle(): int
    {
        $name = $this->ask('Full name');
        $email = $this->ask('Email address');
        $role = $this->choice('Account role', [
            'administrator',
            'admissions_officer',
            'teacher',
            'non_teaching_staff',
            'student',
        ]);
        $password = $this->secret('Password (minimum 12 characters)');

        $validator = Validator::make(
            compact('name', 'email', 'role', 'password'),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
                'role' => ['required', Rule::in([
                    'administrator',
                    'admissions_officer',
                    'teacher',
                    'non_teaching_staff',
                    'student',
                ])],
                'password' => ['required', 'string', 'min:12'],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'password' => Hash::make($password),
        ]);

        $this->info("Created {$role} account for {$email}.");

        return self::SUCCESS;
    }
}
