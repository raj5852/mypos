<?php


// passing : product, mainstock, substock.
//output : 24 pc
function getTotalOpeningStock(object $product,  $mainstock,  $substoct)
{

    $relatedvalue =  $product->main_unit_related_value ?: 1;
    $main_stock =  $mainstock ?: 0;
    $sub_stoct = $substoct ?: 0;

    return ($relatedvalue * $main_stock) + $sub_stoct;
}



function getTotalAvailAbleStock(object $product, $totalstock)
{
    if ($product->main_unit_related_value == '') {
        return  $totalstock . ' ' . $product->main_unit_name;
    } else {
        $firstunit = floor($totalstock / $product->main_unit_related_value);
        $lastunit = $totalstock - ($firstunit * $product->main_unit_related_value);
        return $firstunit . ' ' . $product->main_unit_name . ' ' . $lastunit . ' ' . $product->sub_unit_name;
    }
}


// purchaseprice, mainstock, substock
function TotalProductAmount($price, $mainstock,  $substoct)
{
    $main_stock =  $mainstock ?: 0;
    $sub_stoct = $substoct ?: 0;
    $productPrice = $price ?: 0;

    return $productPrice * ($main_stock . '.' . $sub_stoct);
}
