<?php

declare(strict_types=1);

namespace Tests\Unit\E7;

use App\Events\ReportStatusChanged;
use App\Services\Notifications\NotificationEventKey;
use Tests\TestCase;

final class NotificationEventKeyTest extends TestCase
{
    public function test_key_is_deterministic_for_a_transition(): void
    {
        $event = new ReportStatusChanged('report-1', 'inspection', 'awaiting');

        $this->assertSame(
            'report-status:report-1:inspection:awaiting',
            (new NotificationEventKey())->for($event),
        );
    }
}
