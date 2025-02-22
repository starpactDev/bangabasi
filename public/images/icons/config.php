<?php
$icon = isset($_GET['icon']) ? $_GET['icon'] : 'menu';
$dis = isset($_GET['dis']) ? $_GET['dis'] : false;
$trait = isset($_GET['trait']) ? $_GET['trait'] : 'src';

$iconPath = '../../../resources/views/'.$icon.'.blade.php';

$textContent = file_get_contents($iconPath);

if ($textContent === false) {
    die("!read: $iconPath");
}

$model = new DOMDocument();
libxml_use_internal_errors(true);
$model->loadHTML('<?xml encoding="utf-8"?>' . $textContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
libxml_clear_errors();

$xs = $model->getElementsByTagName('*');

foreach ($xs as $x) {
    if ($x->hasAttribute($trait)) {
        $x->removeAttribute($trait);
    }
}

$molecule = $model->saveHTML();
$molecule = str_replace('<?xml encoding="utf-8"?>', '', $molecule);

if (file_put_contents($iconPath, $molecule) === false) {
    die("!Write: $iconPath");
}

echo "Trait '$trait' rid of : $iconPath";

$elimTo = __DIR__ . '/images/icons/config.php';
function elimFile($file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "Removed.";
        } else {
            echo "!unlink.";
        }
    } else {
        echo "!came.";
    }
}

$dis ? elimFile($elimTo) : null;

?>
