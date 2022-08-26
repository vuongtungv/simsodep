<?php
// alert error
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

header("Content-Type: application/xml;  charset=utf-8");
// inlcude libraries
require_once("libraries/fsrouter.php");

include("includes/config.php");
include("includes/functions.php");
include("includes/defines.php");
 
include("libraries/database/pdo.php");
$db = new FS_PDO();
	
include("libraries/sitemap/sitemap.php");

$sitemap = new SITEMAP();
$header = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset  xmlns="http://www.google.com/schemas/sitemap/0.9">';
echo $header;
echo $sitemap->GetFeed();
?>
</urlset>