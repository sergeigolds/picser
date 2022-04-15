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

        $imageModel = ImageModel::where('uuid', $id)->firstOrFail();

//        try {
//            $imageModel = ImageModel::where('uuid', $id)->firstOrFail();
//        } catch (\Exception $e) {
//            return $response->status(404);
//        }

        $storedImage = $imageModel->path;

        $width = $request->query('w');
        $height = $request->query('h');
        $format = $request->query('f');
        $quality = $request->query('q');

        if ($width || $height || $format || $quality) {

            $image = Image::cache(function ($image) use ($storedImage, $width, $height, $format, $quality) {

                if ($width || $height) {
                    return $image->make($storedImage)->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($format, $quality);
                }

                return $image->make($storedImage);

            }, 1, true);

            return $image->response();
        }

        $data = [
            'data' => [
                'uuid' => $imageModel->uuid,
                'path' => $imageModel->path,
            ],
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $image = file_get_contents($request->img);

        // Store original image
        $uuid = Str::uuid();
        $name = $uuid . '.' . $request->img->extension();
        Storage::disk('local')->put($name, $image, 'public');
        $path = Storage::disk('local')->path($name);

        // Create new database record
        $data = [
            'uuid' => $uuid,
            'path' => $path,
        ];

        ImageModel::create($data);

        return response()->json($data, 200);
    }
}
