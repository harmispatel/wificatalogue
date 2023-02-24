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
                'name'              =>          'Soups',
                'en_name'            =>      'Soups',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 1,
            ],
            [
                'name'              =>          'Junior',
                'en_name'            =>      'Junior',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 2,
            ],
            [
                'name'              =>          'Vegetarian',
                'en_name'            =>      'Vegetarian',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 3,
            ],
            [
                'name'              =>          'Appetizers',
                'en_name'            =>      'Appetizers',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 4,
            ],
            [
                'name'              =>          'Salads',
                'en_name'            =>      'Salads',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 5,
            ],
            [
                'name'              =>          'Pasta',
                'en_name'            =>      'Pasta',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 6,
            ],
            [
                'name'              =>          'Risotto',
                'en_name'            =>      'Risotto',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 7,
            ],
            [
                'name'              =>          'Seafood',
                'en_name'            =>      'Seafood',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 8,
            ],
            [
                'name'              =>          'Fishes',
                'en_name'            =>      'Fishes',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 9,
            ],
            [
                'name'              =>          'Cooked',
                'en_name'            =>      'Cooked',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 10,
            ],
            [
                'name'              =>          'Meat',
                'en_name'            =>      'Meat',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 11,
            ],
            [
                'name'              =>          'Desserts',
                'en_name'            =>      'Desserts',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 12,
            ],
            [
                'name'              =>          'Refreshments',
                'en_name'            =>      'Refreshments',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 13,
            ],
            [
                'name'              =>          'Juices',
                'en_name'            =>      'Juices',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 14,
            ],
            [
                'name'              =>          'Spirits',
                'en_name'            =>      'Spirits',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 15,
            ],
            [
                'name'              =>          'Wines',
                'en_name'            =>      'Wines',
                'description'   =>      'Lorem Ispum doler sit amet',
                'en_description'   =>      'Lorem Ispum doler sit amet',
                'published'     =>      1,
                "shop_id"   => 1,
                "order_key" => 16,
            ],
        ];

        Category::insert($categories);
    }
}
