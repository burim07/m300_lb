<?php

echo "Hello from Burim's Container";

$mysqli = new mysqli("db", "root", "example", "lb3");

$sql = "INSERT INTO users (name, beruf, firma, sprache) VALUES('Lil Float', 'rapper', 'soundcloud', 'englisch')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf, firma, sprache) VALUES('XqcOw', 'streamer', 'twitch', 'franzoesisch')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf, firma, sprache) VALUES('EDP445', 'comedian', 'youtube', 'afrikanisch')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf, firma, sprache) VALUES('Burim Muharemi', 'informatiker', 'Credit Suisse', 'albanisch')";
$result = $mysqli->query($sql);


$sql = 'SELECT * FROM users';

if ($result = $mysqli->query($sql)) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}

foreach ($users as $user) {
    echo "<br>";
    echo $user->name . " " . $user->beruf . " " . $user->firma . " " . $user->sprache;
    echo "<br>";
}