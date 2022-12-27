<?php

/*
 *  Creates a JSON metadata and HTML snippet file.
 *  Bases name off the current date, and orders based on unused file names.
 */

$date = date('Ymd');
$files = null;
for ($order = 1; $order <= 99; $order += 1) {
    $name = $date . '-' . str_pad($order, 2, '0', STR_PAD_LEFT);
    $html = "articles/{$name}.html";
    $json = "articles/{$name}.json";
    if (file_exists($html)) continue;
    if (file_exists($json)) continue;
    $files = [ 'html' => $html, 'json' => $json ];
    break;
}
if ($files === null) {
    echo "Failed to find an unused file name.";
    exit(1);
}

$html = '<p>Text to go here...</p>';

$json = [
    'title' => '',
    'date' => date('Y-m-d'),
    'tags' => []
];

if ($order > 1) {
    $json['order'] = $order;
}

file_put_contents($files['html'], $html);
file_put_contents($files['json'], json_encode($json, JSON_PRETTY_PRINT));
