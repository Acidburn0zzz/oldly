<?php
use Json\Json;

$file = INSTALL_ROOT . 'data/stats.json';

$link = $_GET['link'];
$json_obj = new Json($file);
if (file_exists($file)) {
    $stats = $json_obj->fetchContent();
    if (! is_array($stats)) {
        trigger_error("JSON content is not an array, aborting stats recording.",
                      E_USER_ERROR);
        exit;
    }
} else {
    $stats = [];
}

$stats[$link] = in_array($link, array_keys($stats)) ? $stats[$link] + 1 : 1;

if (! is_dir(INSTALL_ROOT . 'data/')) {
    mkdir(INSTALL_ROOT . 'data/');
}

$json_obj->saveFile($stats, $file, true);
