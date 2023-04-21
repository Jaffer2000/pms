<?php

// Verbinding met de database
$servername = "localhost";
$username = "root";
$password = "";
$db = "ivsuitleensysteem";

$conn = mysqli_connect($servername, $username, $password, $db);
  if (!$conn) {
    die("Connection with Database failed: " . mysqli_connect_error());
  }

// try {
//   $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   //echo "Connected successfully";
// } catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
// }

// Datum in de header vertalen naar Nederlands:

$months = [
  'January' => 'januari',
  'February' => 'februari',
  'March' => 'maart',
  'April' => 'april',
  'May' => 'mei',
  'June' => 'juni',
  'July' => 'juli',
  'August' => 'augustus',
  'September' => 'september',
  'October' => 'oktober',
  'November' => 'november',
  'December' => 'december'
];

$weekdays = [
  'Monday' => 'Maandag',
  'Tuesday' => 'Dinsdag',
  'Wednesday' => 'Woensdag',
  'Thursday' => 'Donderdag',
  'Friday' => 'Vrijdag',
  'Saturday' => 'Zaterdag',
  'Sunday' => 'Zondag'
];

$datetime = date('l j F Y');
$datetime = str_replace(array_keys($months),   array_values($months),   $datetime);
$datetime = str_replace(array_keys($weekdays), array_values($weekdays), $datetime);

date_default_timezone_set('Europe/Amsterdam');
$time = date('d/m/Y H:i', time());

?>