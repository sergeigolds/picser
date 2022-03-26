<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        return Image::all();
    }

    public function show($id)
    {
        return Image::where('id', $id)->firstOrFail();
    }

    public function store(Request $request)
    {g
        $image = file_get_contents($request->img);

        // Modify image
        $name = '/images/modified/' . time() . '.webp';
        $formattedImage = \Intervention\Image\Facades\Image::make($image)->stream("webp", 100);
        Storage::disk('local')->put($name, $formattedImage, 'public');
        $path = Storage::disk('local')->path($name);

        // Store original image
        $originalName = '/images/original/' . $request->img->getClientOriginalName();
        Storage::disk('local')->put($originalName, $image, 'public');
        $originalPath = Storage::disk('local')->path($originalName);

        // Create new database record
        $data = [
            'name' => basename($name),
            'path' => $path,
            'original_name' => basename($originalName),
            'original_path' => $originalPath,
        ];

        Image::create($data);

        return response()->json($data, 200);
    }
}
