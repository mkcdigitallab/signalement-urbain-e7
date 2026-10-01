<?php

declare(strict_types=1);

namespace App\Services\Media;

use App\Contracts\MediaStorage;
use Illuminate\Http\UploadedFile;
use Throwable;

final class ReportMediaService
{
    public function __construct(
        private readonly MediaStorage $storage,
    ) {
    }

    public function store(UploadedFile $file, string $reportId): string
    {
        $path = $this->storage->store($file, 'reports/'.$reportId);

        try {
            return $path;
        } catch (Throwable $exception) {
            $this->storage->delete($path);

            throw $exception;
        }
    }

    public function temporaryUrl(string $path, int $minutes = 10): string
    {
        return $this->storage->temporaryUrl($path, $minutes);
    }
}
