<?php

declare(strict_types=1);

namespace Tests\Unit\E7;

use App\Events\ReportStatusChanged;
use App\Services\Notifications\NotificationEventKey;
use PHPUnit\Framework\TestCase;

final class NotificationEventKeyTest extends TestCase
{
    public function test_status_transition_key_is_deterministic(): void
    {
        $event = new ReportStatusChanged('report-1', 'received', 'assigned');

        self::assertSame(
            'report-status:report-1:received:assigned',
            (new NotificationEventKey())->forStatusChange($event),
        );
    }
}
