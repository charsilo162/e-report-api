<?php

namespace App\Services;
//app/Services/AdminUserService.php

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminUserService extends BaseCrudService
{
    protected string $modelClass = User::class;

    public function list(array $filters = [], int $perPage = 10)
    {
        return User::query()
            ->withCount('reports')
            ->when($filters['role'] ?? null, fn ($q, $role) => $q->where('role', strtolower($role)))
            ->when($filters['status'] ?? null, function ($q, $status) {
                $status === 'Suspended' ? $q->whereNotNull('suspended_at') : $q->whereNull('suspended_at');
            })
            ->latest()
            ->paginate($perPage);
    }

    public function findWithHistory(int $id): User
    {
        return User::withCount('reports')
            ->with(['reports' => fn ($q) => $q->with('categories')->latest()])
            ->findOrFail($id);
    }


public function reactivate(User $user, ?int $actorId = null): User
{
    $user->update(['suspended_at' => null]);
    ActivityLog::log('User Account Reactivated', "User ID #{$user->id}", $actorId);

    return $user->fresh();
}

    public function suspend(User $user, ?int $actorId = null): User
    {
        $user->update(['suspended_at' => now()]);
        ActivityLog::log('User Account Suspended', "User ID #{$user->id}", $actorId);

        return $user->fresh();
    }

    public function resetPassword(User $user, string $newPassword): User
    {
        $user->update(['password' => Hash::make($newPassword)]);

        return $user;
    }

    public function delete(Model $model): void
    {
        ActivityLog::log('User Account Deleted', "User ID #{$model->id}");
        $model->delete();
    }
}