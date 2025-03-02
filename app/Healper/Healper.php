<?php

use App\Models\BankAccount;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $number = $product->id + 1;
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
        // Force decimal places to 2
        $decimalPlaces = 2;
        return number_format(floatval($balance), $decimalPlaces, '.', '');
    }
}

if (!function_exists('formateStock')) {
    function formateStock($mainunit, $subunit, $available)
    {
        if ($subunit != '') {
            $relatedvalue = $mainunit->related_by_value;
            $firstunit = floor($available / $relatedvalue);
            $lastunit = $available - $firstunit * $relatedvalue;

            return $firstunit . ' ' . $mainunit->unit_name . ' ' . $lastunit . ' ' . $subunit->unit_name;
        } else {
            return $available . ' ' . $mainunit->unit_name;
        }
    }
}

if (!function_exists('totalstockvalue')) {
    function totalstockvalue($mainunit, $subunit, $available, $saleprie)
    {
        if ($subunit != '') {
            $relatedvalue = $mainunit->related_by_value;
            return formatBalance(($saleprie / $relatedvalue) * $available);
        } else {
            return formatBalance($available * $saleprie);
        }
    }
}

if (!function_exists('totalunit')) {
    function totalunit($is_subunit, $main_quantity, $sub_quantity, $related_by_value)
    {
        if ($is_subunit == true) {
            return $main_quantity * $related_by_value + $sub_quantity;
        } else {
            return $main_quantity;
        }
    }
}

if (!function_exists('formatedate')) {
    function formatedate($date)
    {
        return $formattedDate = Carbon::parse($date)->format('Y-m-d');
    }
}

if (!function_exists('currentdateFormate')) {
    function currentdateFormate()
    {
        return \Carbon\Carbon::now()->format('Y-m-d');
    }
}

if (!function_exists('rolecheck')) {
    function rolecheck(array $rolename)
    {
        return Auth::user()->roles()->whereIn('name', $rolename)->exists();
    }
}

if (!function_exists('getRedirectUrl')) {
    function getRedirectUrl($roleName)
    {
        $return_value = match ($roleName) {
            'dashboard' => route('dashboard'),
            'owner' => route('owner.index'),
            'bank' => route('bank.index'),
            'pos' => route('pos'),
            'sales' => route('sale'),
            'purchase' => route('purchase.index'),
            'stock' => route('product.stock'),
            'damage' => route('damage.index'),
            'unit' => route('units.index'),
            'product' => route('product.index'),
            'category' => route('category.index'),
            'brand' => route('brand.index'),
            'customer' => route('customer.index'),
            'supplier' => route('supplier.index'),
            'setting' => route('setting.index'),
            'user_and_role' => route('userrole.index'),
            default => route('dashboard'),
        };

        return $return_value;
    }
}



if (!function_exists('getDomainName')) {
    function getDomainName()
    {
        $allDomains =  config('tenancy.central_domains');
        return end($allDomains);
    }
}
