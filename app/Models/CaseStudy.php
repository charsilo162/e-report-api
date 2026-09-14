<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'tag', 'title', 'excerpt', 'image',
        'detail_title', 'case_details', 'evidence',
        'monetary_amount', 'outcome', 'stats',
    ];

    protected $casts = [
        'evidence' => 'array',
        'stats' => 'array',
    ];
}