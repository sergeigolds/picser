<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TestController extends Controller
{
    public function store(Request $request)
    {

        $image =  file_get_contents($request->img);
        $originalName = $request->img->getClientOriginalName();
        $original_path = "orig img path";

        // Change format to WEBP
        $formattedImage = Image::make($image)->stream("webp", 10);
        Storage::disk('local')->put('images/modified/' . time() . '.webp', $formattedImage, 'public');



        // Store original image
        Storage::disk('local')->put('images/original/' . $originalName, $image, 'public');

        // Create new database record
//        $data = [
//            'name' => $name,
//            'path' => $path,
//            'original_name' => $original_name,
//            'original_path' => $original_path,
//        ];
//
//        Image::create($data);

    }
}
