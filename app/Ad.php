<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'title',
        'description',
        'currency_id',
        'price',
        'condition_id',
        'category_id',
        'district_id',
        'user_id',
        'deleted',
    ];
}
