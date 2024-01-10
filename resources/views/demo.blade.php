<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    {{-- @php
        echo DNS1D::getBarcodeHTML('4445645656', 'C39');
echo DNS1D::getBarcodeHTML('4445645656', 'C39+'); //ok
echo DNS1D::getBarcodeHTML('4445645656', 'C39E');
echo DNS1D::getBarcodeHTML('4445645656', 'C39E+');
echo DNS1D::getBarcodeHTML('4445645656', 'C93'); //ok
echo DNS1D::getBarcodeHTML('4445645656', 'S25');
echo DNS1D::getBarcodeHTML('4445645656', 'S25+');
echo DNS1D::getBarcodeHTML('4445645656', 'I25'); //ok
echo DNS1D::getBarcodeHTML('4445645656', 'I25+');
echo DNS1D::getBarcodeHTML('4445645656', 'C128');
echo DNS1D::getBarcodeHTML('4445645656', 'C128A');
echo DNS1D::getBarcodeHTML('4445645656', 'C128B');
echo DNS1D::getBarcodeHTML('4445645656', 'C128C');
echo DNS1D::getBarcodeHTML('4445645656', 'GS1-128');
echo DNS1D::getBarcodeHTML('44455656', 'EAN2');
echo DNS1D::getBarcodeHTML('4445656', 'EAN5');
echo DNS1D::getBarcodeHTML('4445', 'EAN8');
echo DNS1D::getBarcodeHTML('4445', 'EAN13');
echo DNS1D::getBarcodeHTML('4445645656', 'UPCA');
echo DNS1D::getBarcodeHTML('4445645656', 'UPCE');
echo DNS1D::getBarcodeHTML('4445645656', 'MSI');
echo DNS1D::getBarcodeHTML('4445645656', 'MSI+');
echo DNS1D::getBarcodeHTML('4445645656', 'POSTNET');
echo DNS1D::getBarcodeHTML('4445645656', 'PLANET');
echo DNS1D::getBarcodeHTML('4445645656', 'RMS4CC');
echo DNS1D::getBarcodeHTML('4445645656', 'KIX');
echo DNS1D::getBarcodeHTML('4445645656', 'IMB');
echo DNS1D::getBarcodeHTML('4445645656', 'CODABAR');
echo DNS1D::getBarcodeHTML('4445645656', 'CODE11');
echo DNS1D::getBarcodeHTML('4445645656', 'PHARMA');
echo DNS1D::getBarcodeHTML('4445645656', 'PHARMA2T');
    @endphp --}}


    {{-- {!!DNS1D::getBarcodeHTML('00212121212', 'UPCA')!!} --}}
    {!! DNS1D::getBarcodeHTML('00000001', 'C128') !!}

</body>

</html>
