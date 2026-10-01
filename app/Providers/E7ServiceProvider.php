<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\MediaStorage;
use App\Events\ReportStatusChanged;
use App\Infrastructure\Media\S3MediaStorage;
use App\Listeners\InvalidateReportDashboardCache;
use App\Listeners\NotifyConcernedUsers;
use App\Models\Report;
use App\Observers\ReportStatusObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

final class E7ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MediaStorage::class, S3MediaStorage::class);
    }

    public function boot(): void
    {
        Report::observe(ReportStatusObserver::class);

        Event::listen(ReportStatusChanged::class, NotifyConcernedUsers::class);
        Event::listen(ReportStatusChanged::class, InvalidateReportDashboardCache::class);
    }
}
