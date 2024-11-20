<?php

// $mysqli = new mysqli("localhost", "root", "Password", "namaDatabase");
$mysqli = new mysqli("localhost", "root", "", "toko online");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

