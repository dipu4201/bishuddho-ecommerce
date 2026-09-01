<?php

namespace Database\Seeders;

use App\Models\DeliveryZone;
use Illuminate\Database\Seeder;

class DeliveryZoneSeeder extends Seeder
{
    public function run(): void
    {
        DeliveryZone::create([
            'name' => 'Inside Dhaka',
            'name_bn' => 'ঢাকার ভেতরে',
            'fee' => 80,
            'free_delivery_threshold' => 1500,
            'estimated_days_min' => 1,
            'estimated_days_max' => 2,
        ]);

        DeliveryZone::create([
            'name' => 'Outside Dhaka',
            'name_bn' => 'ঢাকার বাইরে',
            'fee' => 130,
            'free_delivery_threshold' => 2000,
            'estimated_days_min' => 2,
            'estimated_days_max' => 4,
        ]);
    }
}
