<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'nickname', 'email', 'phone', 'password', 'role',
        'anonymous_by_default', 'two_factor_enabled',
        'notification_channel', 'notify_on_status_change',
        'wallet_id', 'suspended_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'anonymous_by_default' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'notify_on_status_change' => 'boolean',
            'suspended_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->wallet_id)) {
                $user->wallet_id = static::generateUniqueWalletId();
            }
        });
    }

    protected static function generateUniqueWalletId(): string
    {
        do {
            $walletId = 'WLT-'.Str::upper(Str::random(6));
        } while (static::where('wallet_id', $walletId)->exists());

        return $walletId;
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }
}