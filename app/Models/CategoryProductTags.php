<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductTags extends Model
{
    use HasFactory;


    public function hasOneTag()
    {
        return $this->hasOne(Tags::class,'id','tag_id');
    }
}
