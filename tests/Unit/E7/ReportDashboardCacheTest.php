<?php

declare(strict_types=1);

namespace Tests\Unit\E7;

use App\Services\Dashboard\ReportDashboardCache;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

final class ReportDashboardCacheTest extends TestCase
{
    public function test_invalidate_forgets_the_dashboard_indicator_cache(): void
    {
        Cache::shouldReceive('forget')
            ->once()
            ->with('dashboard:reports:indicators');

        (new ReportDashboardCache())->invalidate();
    }
}
