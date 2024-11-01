<?php

//change the dsn if needed!
$dsn = "mysql:host=localhost;dbname=shop_db";
$dbusername = "root";
$dbpassword = "";

try {
    //try to connect
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}