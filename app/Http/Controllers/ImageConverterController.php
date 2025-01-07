<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ImageConverterController extends Controller
{
    public function convert(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:webp|max:10240', // 10MB max
            'filename' => 'required|string',
            'format' => 'required|in:jpg,jpeg,png,gif'
        ]);
    
        try {
            // Create new instance of ImageManager with GD driver
            $manager = new ImageManager(new ImagickDriver());
    
            // Get the uploaded file
            $uploadedFile = $request->file('file');
            
            // Read the image
            $image = $manager->read($uploadedFile);
    
            // Generate a temporary filename
            $tempFilename = Str::random(40) . '.' . $request->format;
            
            // Prepare the output filename
            $outputFilename = $request->filename;
            if (!Str::endsWith($outputFilename, '.' . $request->format)) {
                $outputFilename .= '.' . $request->format;
            }
    
            // Convert based on requested format
            $encodedImage = match ($request->format) {
                'png' => $image->encode(new PngEncoder()),
                'gif' => $image->encode(new GifEncoder()),
                'jpg', 'jpeg' => $image->encode(new JpegEncoder(quality: 90)),
                default => throw new \Exception('Unsupported format')
            };
    
            // Save the encoded image
            Storage::disk('local')->put(
                'temp/' . $tempFilename,
                $encodedImage
            );
    
            // Return the response as an Inertia response
            return inertia('ImageConverter', [
                'download' => [
                    'success' => true,
                    'filename' => $outputFilename,
                    'tempFilename' => $tempFilename,
                    'url' => route('image.download', ['filename' => $outputFilename, 'tempFilename' => $tempFilename])
                ]
            ]);
    
        } catch (\Exception $e) {
            return inertia('ImageConverter', [
                'error' => 'Failed to convert image: ' . $e->getMessage()
            ]);
        }
    }    

    public function download(Request $request)
    {
        $tempFilename = $request->tempFilename;
        $outputFilename = $request->filename;

        // Verify the temporary file exists
        if (!Storage::disk('local')->exists('temp/' . $tempFilename)) {
            abort(404);
        }

        // Use response()->download to download the file and delete it afterward
        return response()->download(
            Storage::disk('local')->path('temp/' . $tempFilename),
            $outputFilename
        )->deleteFileAfterSend(true);
    }
}
