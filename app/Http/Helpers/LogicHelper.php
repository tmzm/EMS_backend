<?php

namespace App\Http\Helpers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait LogicHelper
{
    public function save_image_to_public_directory(Request $request): bool|string
    {
        try{
            if ($request->hasfile('image')) {
                $image = $request->file('image');
                $imageName = time().'_'.$request->file('image')->getBasename().'.'.$request->file('image')->getClientOriginalExtension();
                copy($image, public_path('images/' . $imageName));
                return '/images/' .  $imageName;
            }
        }catch(Exception $e){
            return '/no-image.jpg';
        }
        return '/no-image.jpg';
    }

    public function delete_image($image_path): void
    {
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
    }
}
