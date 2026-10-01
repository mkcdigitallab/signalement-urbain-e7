<?php

declare(strict_types=1);

namespace App\Infrastructure\Media;

use App\Contracts\MediaStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class S3MediaStorage implements MediaStorage
{
    public function store(UploadedFile $file, string $directory): string
    {
        return Storage::disk('s3')->putFile($directory, $file);
    }

    public function temporaryUrl(string $path, int $minutes): string
    {
        return Storage::disk('s3')->temporaryUrl(
            $path,
            now()->addMinutes($minutes),
        );
    }

    public function delete(string $path): void
    {
        Storage::disk('s3')->delete($path);
    }
}
