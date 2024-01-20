<?php


// passing : product, mainstock, substock.
//output : 24 pc

use App\Models\Product;

function getTotalOpeningStock(object $product,  $mainstock,  $substoct)
{

    $relatedvalue =  $product->main_unit_related_value ?: 1;
    $main_stock =  $mainstock ?: 0;
    $sub_stoct = $substoct ?: 0;

    return ($relatedvalue * $main_stock) + $sub_stoct;
}


// 2 dozon 2 pc
function getTotalAvailAbleStock(object $product, $totalstock)
{
    $firstunit = floor($totalstock / ($product->main_unit_related_value ?: 1));

    if ($product->sub_unit_name == null) {
        return $firstunit . ' ' . $product->main_unit_name;
    } else {
        $lastunit = $totalstock - ($firstunit * $product->main_unit_related_value);
        return $firstunit . ' ' . $product->main_unit_name . ' ' . $lastunit . ' ' . $product->sub_unit_name;
    }
}




// passing : main_unit_related_value, mainstock, substock.
//output : 24 pc
function subtotalQty($main_unit_related_value,  $mainstock,  $substoct)
{

    $relatedvalue =  $main_unit_related_value ?: 1;
    $main_stock =  $mainstock ?: 0;
    $sub_stoct = $substoct ?: 0;

    return ($relatedvalue * $main_stock) + $sub_stoct;
}

//
function  stockQtyValue($total_stock_qty, $main_unit_related_value, $price)
{
    $amount = ($total_stock_qty / ($main_unit_related_value ?: 1)) * ($price ?: 0);

    return formatBalance($amount);
}

// 10-4 = 6
function productStock($purchased, $sellStock)
{
    return formatBalance(($purchased ?: 0) - ($sellStock ?: 0));
}



function SingleProductStock($id)
{
    $product = Product::query()
        ->where('id', $id)
        ->purchased()
        ->sell()
        ->firstOrFail();

    return ($product->purchased - $product->sell);
}
