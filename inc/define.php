<?php
define('DBHOST', 'localhost');
define('DBUSERNAME', 'sjson');
define('DBPW', 'sj7277');
define('DBNAME', 'test');

error_reporting(E_ALL);

ini_set('display_errors', '1');
//DB include
require_once('/var/www/html/inven/inc/dbconnect.php');

//paging
define('PAGING_SIZE', 10);
define('PAGING_SCALE', 10);