<?php

namespace App\Models;
//app/Models/ActivityLog.php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = ['actor_id', 'title', 'detail'];

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public static function log(string $title, string $detail, ?int $actorId = null): self
    {
        return static::create(['actor_id' => $actorId, 'title' => $title, 'detail' => $detail]);
    }
}