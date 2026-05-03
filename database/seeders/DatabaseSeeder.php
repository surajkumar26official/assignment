<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $company = Companies::firstOrCreate(['name' => 'Default Company']);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'company_id' => $company->id,
        ]);
    }
}
