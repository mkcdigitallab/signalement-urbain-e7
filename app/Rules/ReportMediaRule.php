<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Validation\Rules\File;

final class ReportMediaRule
{
    public static function make(): File
    {
        return File::image()
            ->types(config('signalcivique.media.mimes'))
            ->max((int) config('signalcivique.media.max_size_kb'));
    }
}
