<?php
$includes = [];
foreach(glob('packages/*.json') as $file) {
    $sha = sha1(file_get_contents($file));
    $includes[$file] = ['sha1' => $sha];
}


file_put_contents('packages.json', json_encode(['includes' => $includes], JSON_PRETTY_PRINT));
