<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image as ImageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function index()
    {
        return ImageModel::all();
    }

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

        // If any attribute provided, modify image and cache it and return
        if ($width || $height || $format || $quality) {

            $image = Image::cache(function ($image) use ($storedImage, $width, $height, $format, $quality) {

                if ($width || $height) {
                    return $image->make($storedImage)->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($format, $quality);
                }

                return $image->make($storedImage)->encode($format, $quality);

            }, 1, true);

            return $image->response();
        }

        $data = [
            'data' => [
                'path' => $imageModel->path,
            ],
        ];

        // If no attributes provided, return path to original image
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        // Validate image and empty request
        $request->validate([
            'image' => 'required|image|max:5000',
        ]);

        $format = $request->query('f');

        if($format) {

        }

        dd('before store original iamge');

        // Store original image
        $image = $request->image;
        $uuid = Str::uuid();
        $name = $uuid . '.' . $request->image->extension();
        Storage::disk('local')->put($name, file_get_contents($image), 'public');
        $path = Storage::disk('local')->path($name);
//        $url = Storage::disk('local')->url($name);

        $data = [
            'uuid' => $uuid,
            'path' => $path,
        ];

        // Create model
        ImageModel::create($data);

        // Return json with created model data
        return response()->json($data, 200);
    }
}
