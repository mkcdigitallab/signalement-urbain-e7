<?php

declare(strict_types=1);

namespace App\Services\Dashboard;

use App\Models\Report;
use Illuminate\Support\Facades\Cache;

final class ReportDashboardCache
{
    private const KEY = 'dashboard:reports:indicators';

    public function indicators(): array
    {
        return Cache::remember(
            self::KEY,
            now()->addSeconds((int) config('signalcivique.dashboard_cache_ttl', 60)),
            fn (): array => [
                'total' => Report::query()->count(),
                'received' => Report::query()->where('status', 'received')->count(),
                'in_progress' => Report::query()->where('status', 'progress')->count(),
                'resolved' => Report::query()->where('status', 'resolved')->count(),
            ],
        );
    }

    public function invalidate(): void
    {
        Cache::forget(self::KEY);
    }
}
