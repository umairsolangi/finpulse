<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Badge::firstOrCreate(
            ['name' => 'Active Contributor'],
            ['description' => 'awarded for consistent community participation']
        );

        Badge::firstOrCreate(
            ['name' => 'Market Explorer'],
            ['description' => 'awarded for exploring a variety of free content']
        );
    }
}
