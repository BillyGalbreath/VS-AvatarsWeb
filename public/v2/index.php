<?php

$url = explode('/', @$_SERVER['REQUEST_URI']);

$baseskin = parseurl(@$url[2], 'skin20');
$eyecolor = parseurl(@$url[3], 'acid-green');
$hairbase = parseurl(@$url[4], 'bald');
$hairextra = parseurl(@$url[5], 'none');
$mustache = parseurl(@$url[6], 'none');
$beard = parseurl(@$url[7], 'none');
$haircolor = parseurl(@$url[8], 'cordovan.png');

$image = imagecreatefrompng('./baseskin/' . $baseskin . '.png');

combine($image, 'eyecolor', $eyecolor . '.png');
combine($image, 'hairbase/' . $hairbase, $haircolor);
combine($image, 'hairextra/' . $hairextra, $haircolor);
combine($image, 'mustache/' . $mustache, $haircolor);
combine($image, 'beard/' . $beard, $haircolor);

header("Content-type: image/png");
imagepng($image);
exit;

function parseurl($url, $def) {
    return $url === null || trim($url) === '' ? $def : $url;
}

function combine($dst, $dir, $file) {
    $src = @imagecreatefrompng($dir . '/' . $file);
    $mask = @imagecreatefrompng($dir . '/mask.png');
    if ($src == null || $mask == null) {
        return;
    }
    for($x = 0; $x < 256; $x++) {
        for($y = 0; $y < 256; $y++) {
            if(imagecolorat($mask, $x, $y) != 0) {
                @imagesetpixel($dst, $x, $y, @imagecolorat($src, $x, $y));
            }
        }
    }
}
?>
