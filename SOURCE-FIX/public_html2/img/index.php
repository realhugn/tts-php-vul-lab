<?php
include("./function/functions.php");
$img = $_GET['filename'];
$basepath = '/var/www/dz0soai.com/public_html2/img/';
$realBase = realpath($basepath);
$userpath = $basepath . $img;
$realUserPath = realpath($userpath);

if ($realUserPath === false || strpos($realUserPath, $realBase) !== 0) {
    echo "Directory Traversal!";
} else {
    include($realUserPath);
}
