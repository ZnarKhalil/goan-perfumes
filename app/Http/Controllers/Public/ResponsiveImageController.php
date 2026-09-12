<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\WhitespacePathNormalizer;
use Symfony\Component\HttpFoundation\Response;

class ResponsiveImageController extends Controller
{
    private const AllowedWidths = [80, 160, 320, 480, 640, 768, 1080];

    public function __invoke(int $width, string $path): Response
    {
        abort_unless(in_array($width, self::AllowedWidths, true), 404);
        abort_unless($this->isSafePublicImagePath($path), 404);

        $disk = Storage::disk('public');

        abort_unless($disk->exists($path), 404);

        $cachePath = 'responsive-images/'.sha1($path)."-{$width}.webp";

        if (! $disk->exists($cachePath)) {
            $generated = Cache::lock('responsive-image:'.$cachePath, 120)->get(function () use ($disk, $path, $cachePath, $width): bool {
                if (! $disk->exists($cachePath)) {
                    $this->createVariant($path, $cachePath, $width);
                }

                return true;
            });

            if (! $generated) {
                return response('Image generation is in progress.', 503, ['Retry-After' => '1']);
            }
        }

        return response()->file($disk->path($cachePath), [
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'Content-Type' => 'image/webp',
        ]);
    }

    private function isSafePublicImagePath(string $path): bool
    {
        return $path !== ''
            && ! Str::contains($path, ['..', "\0"])
            && ! Str::startsWith($path, ['/', 'responsive-images/'])
            && preg_match('/\A[A-Za-z0-9._\/-]+\z/', $path) === 1
            && (new WhitespacePathNormalizer)->normalizePath($path) === $path;
    }

    private function createVariant(string $sourcePath, string $cachePath, int $targetWidth): void
    {
        $disk = Storage::disk('public');
        $contents = $disk->get($sourcePath);
        $dimensions = @getimagesizefromstring($contents);

        abort_unless($dimensions !== false, 404);

        [$sourceWidth, $sourceHeight] = $dimensions;

        abort_unless($sourceWidth > 0 && $sourceHeight > 0, 404);
        abort_unless($sourceWidth * $sourceHeight <= 40_000_000, 404);

        $image = @imagecreatefromstring($contents);

        abort_unless($image !== false, 404);

        $variantWidth = min($targetWidth, $sourceWidth);
        $variantHeight = max(1, (int) round($sourceHeight * ($variantWidth / $sourceWidth)));
        $variant = imagecreatetruecolor($variantWidth, $variantHeight);

        imagealphablending($variant, false);
        imagesavealpha($variant, true);
        imagecopyresampled(
            $variant,
            $image,
            0,
            0,
            0,
            0,
            $variantWidth,
            $variantHeight,
            $sourceWidth,
            $sourceHeight,
        );

        ob_start();
        $encoded = imagewebp($variant, null, 78);
        $variantContents = ob_get_clean();

        imagedestroy($variant);
        imagedestroy($image);

        abort_unless($encoded && is_string($variantContents), 404);
        abort_unless($disk->put($cachePath, $variantContents), 500);
    }
}
