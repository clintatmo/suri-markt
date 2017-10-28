<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'title',
        'description',
        'currency',
        'price',
        'condition',
        'category',
        'district',
        'user_id',
        'views',
        'deleted',
    ];
}
