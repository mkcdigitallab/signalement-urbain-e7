<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReportStatusChanged;
use App\Models\Notification;
use App\Models\Report;
use App\Services\Notifications\NotificationEventKey;

final class NotifyConcernedUsers
{
    public function __construct(
        private readonly NotificationEventKey $eventKey,
    ) {
    }

    public function handle(ReportStatusChanged $event): void
    {
        $report = Report::query()
            ->with(['user', 'service'])
            ->findOrFail($event->reportId);

        foreach ($this->recipients($report) as $recipientId) {
            Notification::query()->firstOrCreate(
                [
                    'user_id' => $recipientId,
                    'event_key' => $this->eventKey->forStatusChange($event),
                ],
                [
                    'notifiable_type' => Report::class,
                    'notifiable_id' => $report->id,
                    'type' => ReportStatusChanged::class,
                    'data' => [
                        'report_id' => $report->id,
                        'from' => $event->previousStatus,
                        'status' => $event->newStatus,
                    ],
                ],
            );
        }
    }


    /**
     * @return list<string>
     */
    private function recipients(Report $report): array
    {
        $ids = [$report->user_id];

        if ($report->service?->responsable_id !== null) {
            $ids[] = $report->service->responsable_id;
        }

        return array_values(array_unique($ids));
    }
}
