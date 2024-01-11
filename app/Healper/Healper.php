<?php

use App\Models\Product;
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
        if ($file_link != 'assets/images/404.png') {
            File::delete($file_link);
        }
    }
}

function productcode()
{

    $product = Product::latest('id')->first();
    if (!$product) {
        $number = 1;
    } else {
        $number = ($product->id) + 1;
    }

    $data = 8 - strlen($number);

    $result = '';

    for ($i = 0; $i < $data; $i++) {
        $result .= '0';
    }

    return $result . $number;
}

// app/helpers.php

if (!function_exists('formatBalance')) {
    function formatBalance($balance)
    {
        $decimalPlaces = is_float($balance) ? 2 : 0;
        return number_format(floatval($balance), $decimalPlaces, '.', '');
    }
}


if (!function_exists('formateStock')) {

    function formateStock($mainunit, $subunit, $available)
    {
        if ($subunit != '') {
            $relatedvalue = $mainunit->related_by_value;
            $firstunit = floor($available / $relatedvalue);
            $lastunit = $available - ($firstunit * $relatedvalue);

            return $firstunit . ' ' . $mainunit->unit_name . ' ' . $lastunit . ' ' . $subunit->unit_name;
        } else {
            return $available . ' ' . $mainunit->unit_name;
        }
    }
}

