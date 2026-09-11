<?php
/**
 * Image Compression Helper
 *
 * Shrinks uploaded images by resizing oversized dimensions and using a
 * high JPEG quality, instead of crushing quality to hit a small file-size
 * target (that approach produces visible blocking/artifacts on detailed
 * photos). A phone photo at 4000x3000px doesn't need to stay that large
 * to look sharp on a web page - resizing down to a sane max dimension
 * cuts file size dramatically while staying visually "HD".
 */

/**
 * Compress an uploaded image in place (or into a chosen destination).
 *
 * @param string $sourcePath      Temp path of the uploaded file ($_FILES[...]['tmp_name'])
 * @param string $destinationPath Where to save the processed image
 * @param int    $maxDimension    Longest side is capped to this many pixels (never upscales)
 * @param int    $jpegQuality     JPEG quality 0-100 (85 is visually near-lossless)
 * @return bool True on success
 */
function compressUploadedImage($sourcePath, $destinationPath, $maxDimension = 1600, $jpegQuality = 85) {
    $info = @getimagesize($sourcePath);
    if (!$info) {
        return false;
    }

    [$width, $height, $type] = $info;

    switch ($type) {
        case IMAGETYPE_JPEG:
            $source = @imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $source = @imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $source = @imagecreatefromgif($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            $source = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : false;
            break;
        default:
            return false;
    }

    if (!$source) {
        return false;
    }

    // Only scale down, never up - and only if it actually exceeds the cap
    $scale = min(1, $maxDimension / max($width, $height));
    $newWidth = max(1, (int) round($width * $scale));
    $newHeight = max(1, (int) round($height * $scale));

    if ($scale < 1) {
        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG/GIF instead of flattening to black
        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resampled (not resized) copy - the quality-preserving interpolation
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($source);
    } else {
        // Already within the size cap - keep original pixels, just re-encode
        $canvas = $source;
    }

    $saved = false;
    switch ($type) {
        case IMAGETYPE_PNG:
            // PNG compression is always lossless - level 6 is a good size/speed
            // balance and never affects visual quality.
            $saved = imagepng($canvas, $destinationPath, 6);
            break;
        case IMAGETYPE_GIF:
            $saved = imagegif($canvas, $destinationPath);
            break;
        case IMAGETYPE_WEBP:
            $saved = function_exists('imagewebp') ? imagewebp($canvas, $destinationPath, $jpegQuality) : false;
            break;
        case IMAGETYPE_JPEG:
        default:
            $saved = imagejpeg($canvas, $destinationPath, $jpegQuality);
            break;
    }

    imagedestroy($canvas);

    // Safety net: if re-encoding somehow produced a larger file than the
    // original (rare, e.g. a tiny already-optimized image), keep the
    // original instead of the "compressed" version.
    if ($saved && file_exists($destinationPath) && filesize($destinationPath) > filesize($sourcePath)) {
        copy($sourcePath, $destinationPath);
    }

    return $saved && file_exists($destinationPath);
}

/**
 * Convenience wrapper: compress an uploaded image and always save it with
 * the given destination path's own extension preserved from the source
 * type (JPEG in, .jpg out; PNG in, .png out - never forces a JPEG
 * conversion, which would destroy transparency on logos/signatures).
 */
function compressUploadedImageKeepFormat($sourcePath, $destDir, $baseFilename, $maxDimension = 1600, $jpegQuality = 85) {
    $info = @getimagesize($sourcePath);
    if (!$info) {
        return false;
    }

    $extensions = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_WEBP => 'webp',
    ];

    $ext = $extensions[$info[2]] ?? null;
    if (!$ext) {
        return false;
    }

    $filename = $baseFilename . '.' . $ext;
    $destinationPath = rtrim($destDir, '/') . '/' . $filename;

    if (!file_exists($destDir)) {
        mkdir($destDir, 0777, true);
    }

    if (compressUploadedImage($sourcePath, $destinationPath, $maxDimension, $jpegQuality)) {
        return $filename;
    }

    return false;
}

/**
 * Human-readable byte size, e.g. 1258291 -> "1.2 MB"
 */
function formatFileSize($bytes) {
    if ($bytes >= 1024 * 1024) {
        return round($bytes / (1024 * 1024), 1) . ' MB';
    }
    if ($bytes >= 1024) {
        return round($bytes / 1024, 1) . ' KB';
    }
    return $bytes . ' B';
}

/**
 * Build a short "(2.3 MB -> 145 KB, 94% smaller)" string comparing an
 * original uploaded file to the compressed result - call this right after
 * compressUploadedImage()/compressUploadedImageKeepFormat() so the admin
 * actually sees the compression happen instead of it being invisible.
 */
function describeCompressionSavings($originalPath, $compressedPath) {
    if (!file_exists($originalPath) || !file_exists($compressedPath)) {
        return '';
    }

    $before = filesize($originalPath);
    $after = filesize($compressedPath);

    if ($before <= 0) {
        return '';
    }

    $percent = round((1 - $after / $before) * 100);
    $percent_text = $percent > 0 ? "{$percent}% smaller" : 'no size change';

    return ' (' . formatFileSize($before) . ' -> ' . formatFileSize($after) . ', ' . $percent_text . ')';
}
?>
