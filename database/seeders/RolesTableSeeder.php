<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']); 
        $guestRole = Role::firstOrCreate(['name' => 'guest']);

        // Assign admin role to user with ID 1
        $adminUser = User::find(1);

        if ($adminUser && !$adminUser->roles->contains($adminRole->id)) {
            $adminUser->roles()->attach($adminRole->id);
        }
    }
}
