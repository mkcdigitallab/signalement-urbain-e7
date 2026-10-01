<?php

declare(strict_types=1);

namespace Tests\Unit\E7;

use App\Contracts\MediaStorage;
use App\Services\Media\ReportMediaService;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

final class ReportMediaServiceTest extends TestCase
{
    public function test_media_service_delegates_storage(): void
    {
        $storage = Mockery::mock(MediaStorage::class);
        $storage->expects('store')
            ->once()
            ->with(Mockery::type(UploadedFile::class), 'reports/report-1')
            ->andReturn('reports/report-1/photo.webp');

        $service = new ReportMediaService($storage);

        $path = $service->store(
            UploadedFile::fake()->image('photo.webp'),
            'report-1',
        );

        $this->assertSame('reports/report-1/photo.webp', $path);
    }
}
