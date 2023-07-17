<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        
        User::factory()->create([
            'name' => 'Julien',
            'email' => 'test@test.fr',
            'role' => 'freelance',
        ]);
        
        User::factory()->create([
            'name' => 'Roger',
            'email' => 'test2@test.fr',
            'role' => 'client',
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
