<?php
//mysql_connect.php
DEFINE('DB_USER', 'choosen username');
DEFINE('DB_PASSWORD', 'choosen password');
DEFINE('DB_HOST', 'your local host name');
DEFINE('DB_NAME', 'your database name');

// make the connection and then select the database

$dbc = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL: '
mysql_select_db (DB_NAME) OR die ('Could not select the database: ' . mysql_error() );
                                                             
?>                                                             