<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CategoryGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'active', 'order'];

    protected $casts = [
        'active' => 'boolean',
    ];
    protected $dates = ['deleted_at'];
}
