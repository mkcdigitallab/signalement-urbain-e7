<?php

declare(strict_types=1);

namespace Tests\Unit\E7;

use App\Rules\ReportMediaRule;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Tests\TestCase;

final class ReportMediaRuleTest extends TestCase
{
    public function test_valid_image_configuration_accepts_supported_image_mime_and_size(): void
    {
        $validator = ValidatorFacade::make(
            ['photo' => 'x'],
            ['photo' => ReportMediaRule::make()],
        );

        $this->assertInstanceOf(Validator::class, $validator);
    }
}
