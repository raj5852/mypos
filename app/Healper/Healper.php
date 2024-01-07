<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

function uploadimage($file, $path = 'img/', $width = 500, $height = 500)
{
    $filename = $file->hashName();

    // Create an instance of the Intervention Image class
    $img = Image::make($file->getRealPath());

    // Resize the image to 400px by 400px, maintaining the aspect ratio
    $img->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    });

    // Encode the image as a string
    $img = $img->encode();

    // Store the image on the public disk, in the category folder
    Storage::disk('public')->put($path . $filename, $img);

    // Return the relative path of the image
    return "storage/{$path}" . $filename;
}


function filedelete($file_link)
{
    if (File::exists($file_link)) {
        File::delete($file_link);
    }
}
