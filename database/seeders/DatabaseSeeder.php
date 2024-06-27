<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Hash;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            // TestDataSeeder::class
        ]);
        DB::table('DBsync')->insert(['last_sync_date' => Carbon::now()]);
    }
}
