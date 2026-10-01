<?php

declare(strict_types=1);

namespace Tests\Feature\E7;

use App\Events\ReportStatusChanged;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Tests\TestCase;

final class ReportStatusChangedTest extends TestCase
{
    public function test_status_event_is_an_after_commit_event_with_transition_data(): void
    {
        $event = new ReportStatusChanged(
            'report-1',
            'inspection',
            'awaiting',
        );

        $this->assertInstanceOf(ShouldDispatchAfterCommit::class, $event);
        $this->assertSame('report-1', $event->reportId);
        $this->assertSame('inspection', $event->previousStatus);
        $this->assertSame('awaiting', $event->newStatus);
    }
}
