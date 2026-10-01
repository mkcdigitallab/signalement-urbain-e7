<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface MediaStorage
{
    public function store(UploadedFile $file, string $directory): string;

    public function temporaryUrl(string $path, int $minutes): string;

    public function delete(string $path): void;
}
