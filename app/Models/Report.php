<?php

namespace App\Models;

//app/Models/Report.php
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id', 'org_name', 'location', 'incident_date', 'wrongdoing',
    'description', 'report_to', 'is_anonymous', 'status', 'is_urgent', 'passcode', 'wallet_id',
];

protected $casts = [
    'wrongdoing' => 'array',
    'is_anonymous' => 'boolean',
    'is_urgent' => 'boolean',
    'incident_date' => 'date',
];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function suspects(): HasMany
    {
        return $this->hasMany(Suspect::class);
    }

    public function evidenceFiles(): HasMany
    {
        return $this->hasMany(EvidenceFile::class);
    }
 
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}