<?php

namespace App\Models;
//app/Models/WalletTransaction.php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    use HasFactory;

    // protected $fillable = ['user_id', 'report_id', 'type', 'amount', 'status'];
    protected $fillable = ['user_id', 'report_id', 'type', 'amount', 'status', 'account_number', 'bank'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}