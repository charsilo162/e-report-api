<?php
namespace App\Models;
//app/Models/Category.php 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'slug', 'image'];

    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(Report::class);
    }
}