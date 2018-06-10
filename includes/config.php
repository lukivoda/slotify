<?php
ob_start();
session_start();
$timezone =  date_default_timezone_set("Europe/Skopje");
define("DSN","mysql:host=localhost;dbname=slotify");
define("USER","root");
define("PASS","");