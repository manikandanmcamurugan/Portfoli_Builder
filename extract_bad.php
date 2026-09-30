<?php
$content = file_get_contents('c:/xampp/htdocs/Portfolio_Builder/templates/template21.php');
$startPos = strpos($content, '<?php if(!empty(\\)): ?>');
$endPos = strpos($content, '<footer>');
$badBlock = substr($content, $startPos, $endPos - $startPos);
file_put_contents('c:/xampp/htdocs/Portfolio_Builder/bad_block.txt', $badBlock);
echo "Extracted bad block";
