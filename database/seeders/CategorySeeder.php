<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'en_name'            =>      'Soups',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Junior',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Vegetarian',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Appetizers',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Salads',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Pasta',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Risotto',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Seafood',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Fishes',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Cooked',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Meat',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Desserts',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Refreshments',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Juices',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Spirits',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
            [
                'en_name'            =>      'Wines',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
            ],
        ];

        Category::insert($categories);
    }
}
