<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

final class EvidenceStorage
{
    public function store(?UploadedFile $file, string $directory): ?string
    {
        if (! $file) {
            return null;
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::random(32).($extension ? ".{$extension}" : '');

        return $file->storeAs($directory, $filename, 'local');
    }
}
