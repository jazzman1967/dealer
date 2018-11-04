<?php

function connect() {
    $pdo = new PDO('mysql:dbname=dealer;host=yourhost','you@domain.com','your-password');
    return $pdo;
}

?>
