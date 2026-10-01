<?php

declare(strict_types=1);

namespace App\Services\Media;

use App\Models\ReportAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Throwable;

final class StoreReportAttachment
{
    public function __construct(
        private readonly ReportMediaService $media,
    ) {
    }

    public function handle(UploadedFile $file, string $reportId): ReportAttachment
    {
        $path = $this->media->store($file, $reportId);

        try {
            return DB::transaction(
                fn (): ReportAttachment => ReportAttachment::query()->create([
                    'report_id' => $reportId,
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'original_name' => $file->getClientOriginalName(),
                ]),
            );
        } catch (Throwable $exception) {
            $this->media->delete($path);
            throw $exception;
        }
    }
}
