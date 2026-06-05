<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'company_name',
        'category',
        'description',
        'email',
        'phone_number',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
