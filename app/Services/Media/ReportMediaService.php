<?php

declare(strict_types=1);

namespace App\Services\Media;

use App\Contracts\MediaStorage;
use Illuminate\Http\UploadedFile;

final class ReportMediaService
{
    public function __construct(
        private readonly MediaStorage $storage,
    ) {
    }

    public function store(UploadedFile $file, string $reportId): string
    {
        return $this->storage->store($file, 'reports/'.$reportId);
    }

    public function temporaryUrl(string $path, int $minutes = 10): string
    {
        return $this->storage->temporaryUrl($path, $minutes);
    }

    public function delete(string $path): void
    {
        $this->storage->delete($path);
    }
}
