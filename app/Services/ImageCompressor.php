<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\ImageManager;

class ImageCompressor
{
    /**
     * Compress and store image ensuring size <= 100KB (102400 bytes).
     */
    public static function compressAndStore(UploadedFile $file, string $folder = 'students', string $disk = 'public'): string
    {
        $maxSizeBytes = 100 * 1024; // 100 KB
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $extension = 'jpg';
        }

        $filename = $folder . '/' . Str::uuid() . '.' . ($extension === 'png' ? 'png' : 'jpg');

        // If already <= 100KB, store directly
        if ($file->getSize() <= $maxSizeBytes) {
            return $file->storeAs($folder, basename($filename), $disk);
        }

        // Initialize Intervention Image
        $manager = new ImageManager(new Driver());
        $image = $manager->decodePath($file->getRealPath());

        // Scale down dimensions if excessively large
        if ($image->width() > 1000 || $image->height() > 1000) {
            $image->scaleDown(width: 1000, height: 1000);
        }

        // Iteratively lower quality until file size <= 100KB
        $quality = 85;
        $encoded = null;

        while ($quality >= 15) {
            if ($extension === 'png') {
                $encoded = $image->encode(new PngEncoder());
                if (strlen((string) $encoded) <= $maxSizeBytes) {
                    break;
                }
                // Fallback to JPEG if PNG is too large to compress below 100KB
                $encoded = $image->encode(new JpegEncoder($quality));
                $filename = $folder . '/' . Str::uuid() . '.jpg';
            } else {
                $encoded = $image->encode(new JpegEncoder($quality));
            }

            if (strlen((string) $encoded) <= $maxSizeBytes) {
                break;
            }

            $quality -= 15;
        }

        // Final fallback: if still > 100KB, scale down to 500px width and compress
        if (strlen((string) $encoded) > $maxSizeBytes) {
            $image->scaleDown(width: 500, height: 500);
            $encoded = $image->encode(new JpegEncoder(45));
            $filename = $folder . '/' . Str::uuid() . '.jpg';
        }

        Storage::disk($disk)->put($filename, (string) $encoded);

        return $filename;
    }
}
