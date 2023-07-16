<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(9)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.fr',
            'role' => 'admin',
        ]);
        
        User::factory(5)->create([
            'role' => 'client',
            ])->each(function ($user) {
            Mission::factory(2)->create([
                'remote' => false,
            ]);
        });
        
        User::factory(5)->create([
            'role' => 'client',
        ])->each(function ($user) {
            Mission::factory(3)->create([
                'remote' => true,
                'postalcode' => null,
                'city' => null,
            ]);
        });
    }
}
