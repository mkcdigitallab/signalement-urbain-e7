<?php

declare(strict_types=1);

namespace App\Observers;

use App\Events\ReportStatusChanged;
use App\Models\Report;

final class ReportStatusObserver
{
    public function updated(Report $report): void
    {
        if (! $report->wasChanged('status')) {
            return;
        }

        ReportStatusChanged::dispatch(
            (string) $report->getKey(),
            (string) $report->getOriginal('status'),
            (string) $report->getAttribute('status'),
        );
    }
}
