<?php

namespace App\Services;

//app/Services/ReportService.php
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReportService extends BaseCrudService
{
    protected string $modelClass = Report::class;

    public function create(array $data): Report
    {
        return DB::transaction(function () use ($data) {
            $report = Report::create([
                'user_id' => $data['user_id'] ?? null,
                'org_name' => $data['org_name'],
                'location' => $data['location'],
                'incident_date' => $data['incident_date'],
                'wrongdoing' => $data['wrongdoing'],
                'description' => $data['description'],
                'report_to' => $data['report_to'] ?? null,
                'is_anonymous' => $data['is_anonymous'],
                'passcode' => $this->generateUniquePasscode(),
            ]);

            $report->categories()->sync($data['category_ids']);

            foreach ($data['suspects'] as $suspect) {
                $report->suspects()->create($suspect);
            }

            foreach ($data['files'] ?? [] as $file) {
                $path = $file->store("evidence/{$report->id}", 'local');

                $report->evidenceFiles()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ]);
            }

            return $report->fresh(['suspects', 'evidenceFiles', 'categories']);
        });
    }

    public function findByPasscode(string $passcode): Report
    {
        return Report::where('passcode', $passcode)
            ->with(['suspects', 'evidenceFiles', 'categories'])
            ->firstOrFail();
    }

    protected function generateUniquePasscode(): string
    {
        do {
            $passcode = collect(range(1, 4))
                ->map(fn () => Str::upper(Str::random(4)))
                ->implode('-');
        } while (Report::where('passcode', $passcode)->exists());

        return $passcode;
    }

    public function forUser(int $userId, array $filters = [], int $perPage = 10)
{
    return Report::query()
        ->where('user_id', $userId)
        ->when($filters['category'] ?? null, fn ($q, $category) =>
            $q->whereHas('categories', fn ($q2) => $q2->where('label', $category))
        )
        ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
        ->when($filters['from'] ?? null, fn ($q, $from) => $q->whereDate('incident_date', '>=', $from))
        ->when($filters['to'] ?? null, fn ($q, $to) => $q->whereDate('incident_date', '<=', $to))
        ->with('categories')
        ->latest()
        ->paginate($perPage);
}

public function findForUser(int $reportId, int $userId): Report
{
    return Report::where('id', $reportId)
        ->where('user_id', $userId)
        ->with(['suspects', 'evidenceFiles', 'categories'])
        ->firstOrFail();
}


public function forAdmin(array $filters = [], int $perPage = 10)
{
    return Report::query()
        ->when($filters['category_id'] ?? null, fn ($q, $id) =>
            $q->whereHas('categories', fn ($q2) => $q2->where('categories.id', $id))
        )
        ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
        ->when($filters['anonymity'] ?? null, fn ($q, $value) =>
            $q->where('is_anonymous', $value === 'Anonymous')
        )
        ->when($filters['from'] ?? null, fn ($q, $from) => $q->whereDate('incident_date', '>=', $from))
        ->when($filters['to'] ?? null, fn ($q, $to) => $q->whereDate('incident_date', '<=', $to))
        ->with(['categories', 'user'])
        ->latest()
        ->paginate($perPage);
}


public function updateStatus(Report $report, string $status): Report
{
    $report->update(['status' => $status]);

    return $report->fresh();
}

public function delete(Model $model): void
{
    Storage::disk('local')->deleteDirectory("evidence/{$model->id}");
    $model->delete();
}
public function creditWallet(Report $report, string $walletId, float $amount): WalletTransaction
{
    $user = User::where('wallet_id', $walletId)->firstOrFail();

    $report->update(['wallet_id' => $walletId]);

    return WalletTransaction::create([
        'user_id' => $user->id,
        'report_id' => $report->id,
        'type' => 'Credit',
        'amount' => $amount,
        'status' => 'Completed',
    ]);
}

}