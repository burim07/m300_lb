<?php

echo "Hello from Burim's Container";

$mysqli = new mysqli("db", "root", "example", "lb3");

$sql = "INSERT INTO users (name, fav_color) VALUES('Lil Float', 'orange')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, fav_color) VALUES('XqcOw', 'gelb')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, fav_color) VALUES('EDP445', 'blau')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, fav_color) VALUES('Burim Muharemi', 'rot')";
$result = $mysqli->query($sql);


$sql = 'SELECT * FROM users';

if ($result = $mysqli->query($sql)) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}

foreach ($users as $user) {
    echo "<br>";
    echo $user->name . " " . $user->fav_color;
    echo "<br>";
}