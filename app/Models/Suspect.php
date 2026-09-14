<?php
namespace App\Models;
//app/Models/Suspect.php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suspect extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'full_name', 'position', 'phone', 'email'];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}