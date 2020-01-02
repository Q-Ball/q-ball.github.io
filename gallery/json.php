<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function stringContainsArrayValue($string, array $array) {
    foreach($array as $value) {
		if (stripos($string, $value) !== false) return true;
    }
    return false;
}

function scanFolder($path) {
	$di = new RecursiveDirectoryIterator($path);
	$iterator = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
	$files = [];
	$extensions = array('.jpg', '.jpeg', '.png', '.gif');
	foreach ($iterator as $file) {
		if (stringContainsArrayValue($file->getPathname(),$extensions)) {
			$files[] = $file->getPathname();
		}
	}
	asort($files);
	return $files;
}

$jsonArray = [];
//$imagesArray = shuffle(scanFolder("../gallery/Albums/"));
$imagesArray = scanFolder("../gallery/Albums/");

foreach ($imagesArray as $item) {
	$fileInfo = pathinfo($item);
	$jsonArray[] = array("fullpath" => $item, "dirname" => $fileInfo["dirname"], "basename" => $fileInfo["basename"], "extension" => $fileInfo["extension"], "filename" => $fileInfo["filename"]);
}

echo json_encode($jsonArray);

?>
