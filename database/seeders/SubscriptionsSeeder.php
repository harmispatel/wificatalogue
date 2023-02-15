<?php

namespace Database\Seeders;

use App\Models\Subscriptions;
use Illuminate\Database\Seeder;

class SubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscriptions = [
            [
                'name'            =>      'Bronze',
                'description'     =>      "This is Bronze Package, It's available for 6 Months",
                'duration'        =>      6,
                'price'           =>      50,
                'status'          =>      1,
            ],
            [
                'name'            =>      'Silver',
                'description'     =>      "This is Silver Package, It's available for 12 Months",
                'duration'        =>      12,
                'price'           =>      100,
                'status'          =>      1,
            ],
            [
                'name'            =>      'Gold',
                'description'     =>      "This is Gold Package, It's available for 18 Months",
                'duration'        =>      18,
                'price'           =>      150,
                'status'          =>      1,
            ],
            [
                'name'            =>      'Platinum',
                'description'     =>      "This is Platinum Package, It's available for 24 Months",
                'duration'        =>      24,
                'price'           =>      200,
                'status'          =>      1,
            ],
        ];

        Subscriptions::insert($subscriptions);
    }
}
