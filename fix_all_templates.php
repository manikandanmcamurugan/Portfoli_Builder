<?php
$bad = file_get_contents('c:/xampp/htdocs/Portfolio_Builder/bad_block.txt');
$good = file_get_contents('c:/xampp/htdocs/Portfolio_Builder/good_block.txt');

$files = glob('c:/xampp/htdocs/Portfolio_Builder/templates/template*.php');
$count = 0;
foreach ($files as $f) {
    $c = file_get_contents($f);
    if (strpos($c, $bad) !== false) {
        $c = str_replace($bad, $good, $c);
        file_put_contents($f, $c);
        $count++;
    }
}
echo "Fixed $count templates.";
