<?php

namespace App\Rules;

use App\Support\VideoDuration;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

final class MaxVideoDuration implements ValidationRule
{
    public function __construct(private readonly int $maximumSeconds = 60)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            return;
        }

        if (! str_starts_with((string) $value->getMimeType(), 'video/')) {
            return;
        }

        if (! VideoDuration::isWithinLimit($value, $this->maximumSeconds)) {
            $fail('يجب أن تكون مدة الفيديو 60 ثانية أو أقل.');
        }
    }
}
