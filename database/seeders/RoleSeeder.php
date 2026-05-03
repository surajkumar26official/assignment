<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['SuperAdmin', 'Admin', 'Member', 'Sales', 'Manager'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $company = Companies::firstOrCreate(['name' => 'SuperAdmin Company']);
        $existingUser = User::where('email', 'superadmin@test.com')->first();
        if (!$existingUser) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@test.com',
                'password' => bcrypt('password'),
                'company_id' => $company->id,
            ])->assignRole('SuperAdmin');
        }
    }
}
