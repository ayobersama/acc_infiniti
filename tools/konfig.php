<?php
/**
 * Database config variables
 */
define("DB_HOST", "localhost");
define("DB_USER", "tokoinfi_acc");
define("DB_PASSWORD", "x95W8JYk2pprnhz5JH3a");
define("DB_DATABASE", "tokoinfi_acc");
//define("DB_USER", "root");
//define("DB_PASSWORD", "");
//define("DB_DATABASE", "acc_infiniti");

 
//membuat koneksi dengan database
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE) or die('Unable to Connect');
date_default_timezone_set("Asia/Jakarta");

//baca lokasi root 
 $domain='http://localhost';
 
 $thisFile = str_replace('\\', '/', __FILE__);
 $docRoot = $_SERVER['DOCUMENT_ROOT'];
 $webRoot  = str_replace(array($docRoot, 'konfig.php'), '', $thisFile);
 $srvRoot  = str_replace('konfig.php', '', $thisFile);
 define('WEB_ROOT', $webRoot);
 define('SRV_ROOT', $srvRoot);
?>