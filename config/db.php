<?php
/*
$dblocation = "127.0.0.1";
$dbname = "myshop";
$dbuser = "root";
$dbpassword = "root";

$db = mysqli_connect($dblocation, $dbuser, $dbpassword, $dbname);


if (!$db) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
*/
//printf("Host information: %s\n", mysqli_get_host_info($db));

/* close connection */
//mysqli_close($db);


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'myshop');

/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}