<?php # Script 9.2 - mysqli_connect.php

// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database, and sets the encoding.

// Set the database access information as constants:
define('DB_USER', 'you@domain.com');
define('DB_PASSWORD', 'your-password');
define('DB_HOST', 'domain');
define('DB_NAME', 'dealer');

// Make the connection:
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
//Should match enconding on php scripts
mysqli_set_charset($dbc, 'utf8');
