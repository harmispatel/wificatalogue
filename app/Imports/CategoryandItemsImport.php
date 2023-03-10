<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Items;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class CategoryandItemsImport implements ToCollection
{

    protected $shop_id;

    public function __construct($shop_id)
    {
        $this->shop_id = $shop_id;
    }

    public function collection(Collection $rows)
    {
        if(count($rows) > 0)
        {
            $lang_array = isset($rows[0]) ? $rows[0]->toArray() : '';
            $langs = (isset($lang_array) && count($lang_array) > 0) ? array_filter($lang_array) : '';

            // Import Category
            if(count($langs) > 0)
            {
                $max_category_order_key = Category::max('order_key');
                $category_order = (isset($max_category_order_key) && !empty($max_category_order_key)) ? ($max_category_order_key + 1) : 1;

                $category = new Category();
                $category->shop_id = $this->shop_id;
                $category->order_key = $category_order;

                foreach($langs as $key => $lang)
                {
                    $name_key = $lang."_name";
                    $lang_category_name = isset($rows[1][$key]) ? $rows[1][$key] : '';
                    $category->$name_key = $lang_category_name;
                }

                $category->published = 1;
                $category->save();

                return $category;
            }

        }
    }
}
