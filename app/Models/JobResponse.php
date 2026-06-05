<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobResponse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_post_id',
        'full_name',
        'email',
        'phone_number',
        'address',
        'cv',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // No DB-level foreign key, but the relation still resolves on job_post_id.
    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }
}
