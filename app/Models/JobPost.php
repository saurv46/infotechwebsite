<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_title',
        'role',
        'location',
        'engagement',
        'job_description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
