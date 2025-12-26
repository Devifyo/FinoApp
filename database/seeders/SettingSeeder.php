<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // 1. The Global Backup Rule
            // "Total dollar 10% will be backup"
            [
                'key'   => 'backup_percentage',
                'value' => '10', 
                'description' => 'Percentage of total project earnings kept as backup.'
            ],

            // 2. Standard Role Defaults
            // "Who bring project is 30%"
            [
                'key'   => 'default_bidder_percentage',
                'value' => '30',
                'description' => 'Standard share for the person who brought the project.'
            ],
            // "Who develops will be 60%"
            [
                'key'   => 'default_developer_percentage',
                'value' => '60',
                'description' => 'Standard share for the main development team.'
            ],

            // 3. Special Case: Idle Person
            // "10% to idle person if have any" (Used in Solo scenarios)
            [
                'key'   => 'default_idle_percentage',
                'value' => '10',
                'description' => 'Share for the idle partner in solo-developer scenarios.'
            ],
            
            // 4. Solo Developer Scenario
            // "If solely the main developer... 80% will go to person"
            [
                'key'   => 'solo_developer_percentage',
                'value' => '80',
                'description' => 'Total share for a user who acts as both Bidder and Developer alone.'
            ],
        ];
        foreach ($settings as $data) {
            // Using updateOrCreate ensures we don't create duplicates if you run the seeder twice
            Setting::updateOrCreate(
                ['key' => $data['key']], // Check if this key exists
                [
                    'value' => $data['value'],
                    // If you added a description column to migration, uncomment below
                    // 'description' => $data['description'] 
                ]
            );
        }
    }
}