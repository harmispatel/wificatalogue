<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\CategoryProductTags;
use App\Models\Items;
use App\Models\Tags;
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

            if(count($langs) > 0)
            {
                // try
                // {
                    // Import Category
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
                    $cat_id = $category->id;


                    // Insert Items
                    unset($rows[0],$rows[1],$rows[2]);

                    if(count($rows) > 0)
                    {
                        $item_lang_arr = [];
                        foreach($rows as $val1)
                        {
                            if(isset($val1[1]) && !empty($val1[1]) && !in_array($val1[1],$item_lang_arr))
                            {
                                $item_lang_arr[] = $val1[1];
                            }
                        }

                        $item_lang_arr = array_filter($item_lang_arr);

                        $max_item_order_key = Items::max('order_key');
                        $item_order = (isset($max_item_order_key) && !empty($max_item_order_key)) ? ($max_item_order_key + 1) : 1;

                        if(count($langs) > 0)
                        {
                            $product_ids = [];
                            $tag_ids = [];

                            foreach($langs as $key => $item_lang)
                            {
                                if($key <= 0)
                                {
                                    $def_key = 0;
                                    $def_tag_key = 0;
                                    foreach($rows as $item)
                                    {
                                        $item_price_arr = [];

                                        if($item[1] == $item_lang)
                                        {
                                            $item_name_key = $item[1]."_name";
                                            $item_description_key = $item[1]."_description";
                                            $item_price_key = $item[1]."_price";

                                            $published = isset($item[28]) ? $item[28] : 1;
                                            $item_type = isset($item[27]) ? $item[27] : 1;
                                            $tags = isset($item[25]) ? explode(',',$item[25]) : [];
                                            $item_image = isset($item[24]) ? $item[24] : '';

                                            $item_price_arr['price'] = [
                                                (isset($item[5])) ? $item[5] : '',
                                                (isset($item[7])) ? $item[7] : '',
                                                (isset($item[9])) ? $item[9] : '',
                                                (isset($item[11])) ? $item[11] : '',
                                                (isset($item[13])) ? $item[13] : '',
                                                (isset($item[15])) ? $item[15] : '',
                                                (isset($item[17])) ? $item[17] : '',
                                                (isset($item[19])) ? $item[19] : '',
                                                (isset($item[21])) ? $item[21] : '',
                                                (isset($item[23])) ? $item[23] : '',
                                            ];

                                            $item_price_arr['label'] = [
                                                (isset($item[4])) ? $item[4] : '',
                                                (isset($item[6])) ? $item[6] : '',
                                                (isset($item[8])) ? $item[8] : '',
                                                (isset($item[10])) ? $item[10] : '',
                                                (isset($item[12])) ? $item[12] : '',
                                                (isset($item[14])) ? $item[14] : '',
                                                (isset($item[16])) ? $item[16] : '',
                                                (isset($item[18])) ? $item[18] : '',
                                                (isset($item[20])) ? $item[20] : '',
                                                (isset($item[22])) ? $item[22] : '',
                                            ];

                                            $price_array['price'] = isset($item_price_arr['price']) ? array_filter($item_price_arr['price']) : [];
                                            $price_array['label'] = isset($item_price_arr['label']) ? $item_price_arr['label'] : [];

                                            if(count($price_array['price']) > 0)
                                            {
                                                $price = serialize($price_array);
                                            }
                                            else
                                            {
                                                $price = NULL;
                                            }

                                            $new_item = new Items();
                                            $new_item->category_id = $cat_id;
                                            $new_item->shop_id = $this->shop_id;
                                            $new_item->order_key = $item_order;
                                            $new_item->type = $item_type;

                                            $new_item->name = $item[2];
                                            $new_item->$item_name_key = $item[2];
                                            $new_item->description = $item[3];
                                            $new_item->$item_description_key = $item[3];
                                            $new_item->price = $price;
                                            $new_item->$item_price_key = $price;

                                            $new_item->published = $published;
                                            $new_item->image = $item_image;
                                            $new_item->save();

                                            // Insert Tags & Update Tags
                                            if(count($tags) > 0)
                                            {
                                                foreach ($tags as $key => $tag)
                                                {
                                                    $tag_name_key = $item[1]."_name";
                                                    $findTag = Tags::where('name',mb_strtolower($tag))->where($tag_name_key,mb_strtolower($tag))->first();
                                                    $tag_id = (isset($findTag->id) && !empty($findTag->id)) ? $findTag->id : '';

                                                    if(!empty($tag_id) || $tag_id != '')
                                                    {
                                                        $edit_tag = Tags::find($tag_id);
                                                        $edit_tag->name = mb_strtolower($tag);
                                                        $edit_tag->$item_name_key = mb_strtolower($tag);
                                                        $edit_tag->update();

                                                        if($edit_tag->id)
                                                        {
                                                            $cat_pro_tag = new CategoryProductTags();
                                                            $cat_pro_tag->tag_id = $edit_tag->id;
                                                            $cat_pro_tag->category_id = $cat_id;
                                                            $cat_pro_tag->item_id = $new_item->id;
                                                            $cat_pro_tag->save();
                                                        }

                                                    }
                                                    else
                                                    {
                                                        $tag_max_order = Tags::max('order');
                                                        $tag_order = (isset($tag_max_order) && !empty($tag_max_order)) ? ($tag_max_order + 1) : 1;

                                                        $new_tag = new Tags();
                                                        $new_tag->name = mb_strtolower($tag);
                                                        $new_tag->$item_name_key = mb_strtolower($tag);
                                                        $new_tag->order = $tag_order;
                                                        $new_tag->save();

                                                        $tag_ids[$def_tag_key] = $new_tag->id;

                                                        if($new_tag->id)
                                                        {
                                                            $cat_pro_tag = new CategoryProductTags();
                                                            $cat_pro_tag->tag_id = $new_tag->id;
                                                            $cat_pro_tag->category_id = $cat_id;
                                                            $cat_pro_tag->item_id = $new_item->id;
                                                            $cat_pro_tag->save();
                                                        }

                                                        $def_tag_key++;
                                                    }

                                                }
                                            }

                                            $product_ids[$def_key] = $new_item->id;
                                            $def_key++;
                                        }
                                    }
                                }
                                else
                                {
                                    $def_key = 0;
                                    $def_tag_key = 0;

                                    foreach($rows as $item)
                                    {
                                        if($item[1] == $item_lang)
                                        {
                                            $ins_item_id = $product_ids[$def_key];

                                            $item_name_key = $item[1]."_name";
                                            $item_description_key = $item[1]."_description";
                                            $item_price_key = $item[1]."_price";
                                            $lang_tags = isset($item[25]) ? explode(',',$item[25]) : [];

                                            $item_price_arr['price'] = [
                                                (isset($item[5])) ? $item[5] : '',
                                                (isset($item[7])) ? $item[7] : '',
                                                (isset($item[9])) ? $item[9] : '',
                                                (isset($item[11])) ? $item[11] : '',
                                                (isset($item[13])) ? $item[13] : '',
                                                (isset($item[15])) ? $item[15] : '',
                                                (isset($item[17])) ? $item[17] : '',
                                                (isset($item[19])) ? $item[19] : '',
                                                (isset($item[21])) ? $item[21] : '',
                                                (isset($item[23])) ? $item[23] : '',
                                            ];

                                            $item_price_arr['label'] = [
                                                (isset($item[4])) ? $item[4] : '',
                                                (isset($item[6])) ? $item[6] : '',
                                                (isset($item[8])) ? $item[8] : '',
                                                (isset($item[10])) ? $item[10] : '',
                                                (isset($item[12])) ? $item[12] : '',
                                                (isset($item[14])) ? $item[14] : '',
                                                (isset($item[16])) ? $item[16] : '',
                                                (isset($item[18])) ? $item[18] : '',
                                                (isset($item[20])) ? $item[20] : '',
                                                (isset($item[22])) ? $item[22] : '',
                                            ];

                                            $price_array['price'] = isset($item_price_arr['price']) ? array_filter($item_price_arr['price']) : [];
                                            $price_array['label'] = isset($item_price_arr['label']) ? $item_price_arr['label'] : [];

                                            if(count($price_array['price']) > 0)
                                            {
                                                $price = serialize($price_array);
                                            }
                                            else
                                            {
                                                $price = NULL;
                                            }

                                            $edit_item =  Items::find($ins_item_id);

                                            $edit_item->name = $item[2];
                                            $edit_item->$item_name_key = $item[2];
                                            $edit_item->description = $item[3];
                                            $edit_item->$item_description_key = $item[3];
                                            $edit_item->price = $price;
                                            $edit_item->$item_price_key = $price;

                                            $edit_item->update();

                                            // Insert & Update Tags
                                            if(count($lang_tags) > 0)
                                            {
                                                foreach ($lang_tags as $key => $tag)
                                                {
                                                    $ins_tag_id = isset($tag_ids[$def_tag_key]) ? $tag_ids[$def_tag_key] : '';

                                                    if(!empty($ins_tag_id))
                                                    {
                                                        $edit_tag = Tags::find($ins_tag_id);
                                                        $edit_tag->$item_name_key = mb_strtolower($tag);
                                                        $edit_tag->update();

                                                        $def_tag_key++;
                                                    }
                                                }
                                            }

                                            $def_key++;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    return redirect()->route('admin.import.export')->with('success',"Data has been Imported SuccessFully");
                // }
                // catch (\Throwable $th)
                // {
                //     return redirect()->route('admin.import.data')->with('error','Oops Something Went Wrong!');
                // }


            }
            else
            {
                return redirect()->route('admin.import.data')->with('error','Oops Something Went Wrong!');
            }

        }
        else
        {
            return redirect()->route('admin.import.data')->with('error','Oops Something Went Wrong!');
        }
    }
}
