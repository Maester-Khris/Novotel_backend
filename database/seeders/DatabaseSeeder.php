<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 users
        
        $clients = \App\Models\Client::factory()->count(50)->create();
        $companies = \App\Models\Company::factory()->count(15)->create();
        $users = \App\Models\User::factory()->count(20)->create(['company_id'=>  $companies->random()->id ]);
        $resources = \App\Models\Resource::factory()->count(100)->create(['company_id'=>  $companies->random()->id ]);

        \App\Models\Visit::factory()
        ->count(50)
        ->create([
            'company_id' => $companies->random()->id,
            'client_id' => $clients->random()->id,
            'resource_id' => $resources->random()->id
        ]);
    }
}
