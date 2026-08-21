<?php

namespace App\CPU;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageManager
{
    public static function upload(string $dir, string $format, $image, $default_image_name = null)
    {
        
        if ($image != null) {
            if(in_array($image->getClientOriginalExtension(), ['gif', 'svg'])){
                $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $image->getClientOriginalExtension();
            }else{
                $image_make = Image::make($image);
                // Honour the EXIF orientation so portrait photos taken on phones keep
                // their original orientation instead of appearing rotated/landscape
                // after re-encoding (the tag is dropped during encode). We read the
                // orientation from the file bytes directly so this works even when the
                // PHP "exif" extension is not installed (Intervention's orientate()
                // throws without it, which silently left images rotated on production).
                self::applyOrientation($image_make, $image);
                // Resize if wider than 1200px — keeps quality without huge file sizes
                if ($image_make->width() > 1200) {
                    $image_make->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                $image_webp = $image_make->encode($format, 75);
                $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            }

            if (!Storage::disk()->exists($dir)) {
                Storage::disk()->makeDirectory($dir);
            }

            if(in_array($image->getClientOriginalExtension(), ['gif', 'svg'])) {
                Storage::disk()->put($dir . $imageName, file_get_contents($image));
            }else{
                Storage::disk()->put($dir . $imageName, $image_webp);

                // Generate thumbnail for ad images (used in home page cards)
                if (str_starts_with($dir, 'ad/') && !str_starts_with($dir, 'ad/thumbnail/')) {
                    $thumbDir = 'ad/thumbnail/';
                    if (!Storage::disk()->exists($thumbDir)) {
                        Storage::disk()->makeDirectory($thumbDir);
                    }
                    $thumb = clone $image_make;
                    $thumb->fit(600, 450,  function ($constraint) {
                        $constraint->upsize();
                    });
                    $thumbWebp = $thumb->encode($format, 70);
                    Storage::disk()->put($thumbDir . $imageName, $thumbWebp);
                    $thumbWebp->destroy();
                    $thumb->destroy();
                }

                $image_webp->destroy();
            }

        } else {
            $imageName = $default_image_name;
        }

        return $imageName;
    }

    public static function file_upload(string $dir, string $format, $file = null)
    {
        if ($file != null) {
            $fileName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if (!Storage::disk()->exists($dir)) {
                Storage::disk()->makeDirectory($dir);
            }
            Storage::disk()->put($dir . $fileName, file_get_contents($file));
        } else {
            $fileName = 'def.png';
        }

        return $fileName;
    }

    public static function update(string $dir, $old_image, string $format, $image, $file_type = 'image')
    {
        if (Storage::disk()->exists($dir . $old_image)) {
            Storage::disk()->delete($dir . $old_image);
        }

        $imageName = $file_type == 'file' ? ImageManager::file_upload($dir, $format, $image) : ImageManager::upload($dir, $format, $image, 'image.def');

        return $imageName;
    }

    public static function delete($full_path)
    {
        if (Storage::disk()->exists($full_path)) {
            Storage::disk()->delete($full_path);
        }

        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];

    }

    /**
     * Physically rotate/flip an Intervention image to match its EXIF orientation.
     * Uses a manual EXIF parser (no dependency on the PHP "exif" extension) and
     * Intervention's pure-GD rotate()/flip(), so it works on any server.
     */
    private static function applyOrientation($image_make, $source)
    {
        try {
            $path = ($source instanceof \SplFileInfo) ? $source->getPathname() : (is_string($source) ? $source : null);
            if (!$path || !is_readable($path)) {
                return;
            }

            $orientation = self::readJpegOrientation($path);

            switch ($orientation) {
                case 2: $image_make->flip('h'); break;
                case 3: $image_make->rotate(180); break;
                case 4: $image_make->rotate(180)->flip('h'); break;
                case 5: $image_make->rotate(270)->flip('h'); break;
                case 6: $image_make->rotate(270); break;
                case 7: $image_make->rotate(90)->flip('h'); break;
                case 8: $image_make->rotate(90); break;
                default: /* 1 or unknown: nothing to do */ break;
            }
        } catch (\Throwable $e) {
            // Never let orientation handling break an upload.
        }
    }

    /**
     * Read the EXIF Orientation value (1-8) from a JPEG file by parsing its
     * APP1/Exif segment manually. Returns 1 (normal) for non-JPEGs or when no
     * orientation tag is present.
     */
    private static function readJpegOrientation($path)
    {
        $fp = @fopen($path, 'rb');
        if (!$fp) {
            return 1;
        }

        try {
            if (fread($fp, 2) !== "\xFF\xD8") {
                return 1; // not a JPEG (SOI marker missing)
            }

            while (!feof($fp)) {
                $marker = fread($fp, 2);
                if (strlen($marker) < 2 || $marker[0] !== "\xFF") {
                    break;
                }
                $type = ord($marker[1]);
                // Start of Scan / End of Image — stop, no more metadata after this
                if ($type === 0xDA || $type === 0xD9) {
                    break;
                }
                $lenBytes = fread($fp, 2);
                if (strlen($lenBytes) < 2) {
                    break;
                }
                $len = (ord($lenBytes[0]) << 8) + ord($lenBytes[1]);
                if ($len < 2) {
                    break;
                }
                $segment = $len > 2 ? fread($fp, $len - 2) : '';
                if ($type === 0xE1 && strncmp($segment, "Exif\x00\x00", 6) === 0) {
                    return self::parseTiffOrientation(substr($segment, 6));
                }
            }
        } finally {
            fclose($fp);
        }

        return 1;
    }

    private static function parseTiffOrientation($tiff)
    {
        if (strlen($tiff) < 8) {
            return 1;
        }

        $order = substr($tiff, 0, 2);
        if ($order === 'II') {
            $le = true;
        } elseif ($order === 'MM') {
            $le = false;
        } else {
            return 1;
        }

        $u16 = function ($offset) use ($tiff, $le) {
            if ($offset + 2 > strlen($tiff)) return null;
            $d = substr($tiff, $offset, 2);
            return $le ? unpack('v', $d)[1] : unpack('n', $d)[1];
        };
        $u32 = function ($offset) use ($tiff, $le) {
            if ($offset + 4 > strlen($tiff)) return null;
            $d = substr($tiff, $offset, 4);
            return $le ? unpack('V', $d)[1] : unpack('N', $d)[1];
        };

        $ifdOffset = $u32(4);
        if ($ifdOffset === null) return 1;

        $count = $u16($ifdOffset);
        if ($count === null) return 1;

        for ($i = 0; $i < $count; $i++) {
            $entry = $ifdOffset + 2 + ($i * 12);
            $tag = $u16($entry);
            if ($tag === null) break;
            if ($tag === 0x0112) { // Orientation
                $value = $u16($entry + 8);
                return ($value >= 1 && $value <= 8) ? $value : 1;
            }
        }

        return 1;
    }
}
