<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert data for admin user
        DB::table('users')->insert([
            'uuid' => Str::uuid(),
            'company_id'  => null,
            'full_name' => "Admin Tech Bookingo",
            'telephone' => "6222222222",
            'password' => Hash::make('admin bookingo'),
            'is_manager' => true,
            'is_receptionist' => false,
        ]);
        // insert police officer uer
        DB::table('users')->insert([
            'uuid' => Str::uuid(),
            'company_id'  => null,
            'full_name' => "Commissariat 5e",
            'telephone' => "622356782",
            'password' => Hash::make('admin dgsn5'),
            'is_manager' => false,
            'is_receptionist' => false,
        ]);
        // \App\Models\User::factory()->count(2160)->create();
    }
}
