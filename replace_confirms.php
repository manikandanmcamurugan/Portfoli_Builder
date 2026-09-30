<?php
$files = glob('c:/xampp/htdocs/Portfolio_Builder/dashboard/*.php');
foreach ($files as $f) {
    $c = file_get_contents($f);
    if (preg_match('/onsubmit="return confirm\([^)]+\);"/', $c)) {
        $c = preg_replace('/onsubmit="return confirm\(\'([^\']+)\'\);"/', 'class="delete-form" data-confirm-msg="$1"', $c);
        file_put_contents($f, $c);
        echo "Updated $f\n";
    }
}
