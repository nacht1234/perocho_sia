<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffUserSeeder extends Seeder
{
    public function run(): void
    {
        $staffRole = Role::where('name', 'staff')->first();

        $staff1 = User::create([
            'name' => 'staff1',
            'email' => 'staff1@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $staff2 = User::create([
            'name' => 'staff2',
            'email' => 'staff2@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $staff1->roles()->attach($staffRole);
        $staff2->roles()->attach($staffRole);
    }
}
