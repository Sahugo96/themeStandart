<?php
$f = 'd:/OSPanel6/home/koritan.local/wp-content/themes/theme-standart/inc/contact-data-admin.php';
if (file_exists($f)) {
    $s = file_get_contents($f);
    echo 'function defined: ' . (strpos($s, 'function tolstenko_contact_get_image_attrs') !== false ? 'YES' : 'NO') . PHP_EOL;
}
$f2 = 'd:/OSPanel6/home/koritan.local/wp-content/themes/theme-standart/functions.php';
if (file_exists($f2)) {
    $s2 = file_get_contents($f2);
    echo 'require_once contact-data-admin in functions.php: ' . (strpos($s2, 'contact-data-admin') !== false ? 'YES' : 'NO') . PHP_EOL;
}
