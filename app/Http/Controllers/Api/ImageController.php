<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image as ImageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function show($id, Request $request)
    {
        // Get image model with uuid provided by request
        $imageModel = ImageModel::where('uuid', $id)->firstOrFail();
        $storedImage = $imageModel->path;

        // Get request attributes
        $width = $request->query('w');
        $height = $request->query('h');
        $format = $request->query('f');
        $quality = $request->query('q');

        // If any attribute provided, modify image and cache it
        if ($width || $height || $format || $quality) {

            $image = Image::cache(function ($image) use ($storedImage, $width, $height, $format, $quality) {

                if ($width || $height) {
                    return $image->make($storedImage)->fit($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($format, $quality);
                }

                return $image->make($storedImage)->encode($format, $quality);

            }, 1, true);

            return $image->response();
        }

        $data = [
            'data' => [
                'url' => $imageModel->url,
            ],
        ];

        // If no attributes provided, return url of original image
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        // Validate image and empty request
        $request->validate([
            'image' => 'required|image|max:5000',
        ]);

        // Store image
        $image = $request->image;
        $format = $request->query('f');
        $uuid = Str::uuid();
        $name = 'public/' . $uuid . '.' . $request->image->extension();

        // If format provided -> change format of original image and store
        if ($format) {
            $image = Image::make($image)->encode($format);
            $name = 'public/' . $uuid . '.' . basename($image->mime());

            Storage::disk('local')->put($name, $image, 'public');
        } else {
            Storage::disk('local')->put($name, file_get_contents($image), 'public');
        }

        $url = Storage::disk('local')->url($name);
        $path = Storage::disk('local')->path($name);

        $data = [
            'uuid' => $uuid,
            'url' => $url,
            'path' => $path,
        ];

        // Create model
        ImageModel::create($data);

        // Remove path from response
        array_pop($data);

        // Return json with created model data
        return response()->json($data, 200);
    }

    public function delete($id, Request $request)
    {
        // Get image model with uuid provided by request
        $imageModel = ImageModel::where('uuid', $id)->firstOrFail();
        $storedImage = $imageModel->path;

        // Delete image from storage
        File::delete($storedImage);

        // Delete image model
        $imageModel->delete();
    }

    public function edit($id, Request $request)
    {
        // If new format provided
        if ($format = $request->query('f')) {
            // Get image model with uuid provided by request
            $imageModel = ImageModel::where('uuid', $id)->firstOrFail();
            $storedImage = $imageModel->path;

            // If new format provided edit and save with new format
            $name = 'public/' . $id . '.' . $format;

            $image = Image::make($storedImage)->encode($format);
            Storage::disk('local')->put($name, $image, 'public');

            // Delete old original file
            File::delete($imageModel->path);

            // Change path and url in model
            $imageModel->url = Storage::disk('local')->url($name);
            $imageModel->path = Storage::disk('local')->path($name);
            $imageModel->save();
        }
    }
}
