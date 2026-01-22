<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Admin',
            'Teacher',
            'Registrar',
            'Student'
        ];

        foreach ($roles as $roleName) {
            $role = \Spatie\Permission\Models\Role::findByName($roleName);
            for ($i = 1; $i <= 3; $i++) {
                $user = \App\Models\User::factory()->create([
                    'username' => strtolower($roleName) . $i,
                    'email' => strtolower($roleName) . $i . '@app.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('1234'),
                ]);
                $user->assignRole($role);
            }
        }

        // Create specific Bachelor Student
        $bachelorUser = \App\Models\User::factory()->create([
            'username' => 'bachelor1',
            'email' => 'bachelor1@app.com',
            'password' => \Illuminate\Support\Facades\Hash::make('1234'),
        ]);
        $bachelorUser->assignRole('Student');
    }
}