<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Symfony\Component\Process\Process;
use Throwable;

final class VideoDuration
{
    public static function isWithinLimit(UploadedFile $file, int $maximumSeconds = 60): bool
    {
        $filePath = $file->getRealPath();

        if (! $filePath) {
            return false;
        }

        try {
            $process = new Process([
                env('FFPROBE_PATH', 'ffprobe'),
                '-v',
                'error',
                '-show_entries',
                'format=duration',
                '-of',
                'default=noprint_wrappers=1:nokey=1',
                $filePath,
            ]);
            $process->setTimeout(15);
            $process->run();

            if (! $process->isSuccessful()) {
                return false;
            }

            $duration = trim($process->getOutput());

            return is_numeric($duration) && (float) $duration <= $maximumSeconds;
        } catch (Throwable) {
            return false;
        }
    }
}
