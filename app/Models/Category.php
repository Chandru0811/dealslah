<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_group_id', 'name', 'slug', 'description', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $dates = ['deleted_at'];
}
