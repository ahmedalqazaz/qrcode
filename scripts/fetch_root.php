<?php
$html = @file_get_contents('http://127.0.0.1:8000/');
if ($html === false) {
    echo "FAILED_TO_FETCH\n";
    exit(1);
}
file_put_contents(__DIR__ . '/root.html', $html);
echo "SAVED\n";
