<?php
$files = glob('c:/xampp/htdocs/Portfolio_Builder/templates/template*.php');
$err = 0;
foreach ($files as $f) {
    exec("c:\\xampp\\php\\php.exe -l " . escapeshellarg($f), $out, $code);
    if ($code !== 0) {
        $err++;
        echo "Error in $f\n";
    }
}
if ($err == 0) {
    echo "All templates syntax check passed.";
}
