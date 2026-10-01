<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReportStatusChanged;
use App\Services\Dashboard\ReportDashboardCache;

final class InvalidateReportDashboardCache
{
    public function __construct(
        private readonly ReportDashboardCache $cache,
    ) {
    }

    public function handle(ReportStatusChanged $event): void
    {
        $this->cache->invalidate();
    }
}
