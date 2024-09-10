<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'name', 
        'legal_name',
        'slug',
        'email',
        'description',
        'external_url',
        'address',
        'timezone_id',
        'current_billing_plan',
        'card_holder_name',
        'card_brand',
        'card_last_four',
        'trial_ends_at',
        'active',
        'ph_number',
        'email_id',
        'shop_ratings'
    ];

    protected $dates = ['deleted_at'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
