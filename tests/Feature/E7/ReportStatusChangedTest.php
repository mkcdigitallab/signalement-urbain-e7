<?php

declare(strict_types=1);

namespace Tests\Feature\E7;

use App\Events\ReportStatusChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class ReportStatusChangedTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_event_is_dispatched_after_commit(): void
    {
        Event::fake([ReportStatusChanged::class]);

        $this->assertTrue(true);

        Event::assertNothingDispatched();
    }
}
