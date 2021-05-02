<?php

echo "Hello from Burim's Container";

$mysqli = new mysqli("db", "root", "example", "lb03b");

$sql = "INSERT INTO users (name, beruf) VALUES('Lil Float', 'rapper')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf) VALUES('XqcOw', 'streamer')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf) VALUES('EDP445', 'comedian')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf) VALUES('Burim Muharemi', 'informatiker')";
$result = $mysqli->query($sql);


$sql = 'SELECT * FROM users';

if ($result = $mysqli->query($sql)) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}

foreach ($users as $user) {
    echo "<br>";
    echo $user->name . " " . $user->beruf;
    echo "<br>";
}