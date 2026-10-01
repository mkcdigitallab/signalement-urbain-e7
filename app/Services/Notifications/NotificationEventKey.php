<?php

declare(strict_types=1);

namespace App\Services\Notifications;

use App\Events\ReportStatusChanged;

final class NotificationEventKey
{
    public function forStatusChange(ReportStatusChanged $event): string
    {
        return sprintf(
            "report-status:%s:%s:%s",
            $event->reportId,
            $event->previousStatus,
            $event->newStatus,
        );
    }
}
