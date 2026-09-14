<?php
namespace App\Models;
//app/Models/EvidenceFile.php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenceFile extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'original_name', 'path', 'size', 'mime'];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}