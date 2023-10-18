<h2>Available Databases</h2>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<?php
    $dbhost = 'localhost';
    $dbuser = 'noahring'; 
    $dbpass = 'Bear1fan$';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
?>
<?php

    if ($conn->connect_errno) {
        echo "Error: Failed to make a MySQL connection, here is why: ". "<br>";
        echo "Errno: " . $conn->connect_errno . "\n";
        echo "Error: " . $conn->connect_error . "\n";
        exit; // Quit this PHP script if the connection fails.
    } else {
        echo "Connected Successfully!" . "<br>";
        echo "YAY!" . "<br>";
    }
?>
<br>
<?php
    $dblist = "SHOW databases";
    $result = $conn->query($dblist);
?>
<?php
    while ($dbname = $result->fetch_array()) {
        echo $dbname['Database'] . "<br>";
    }
?>
<?php
    $conn->close();
?>
<h2>Check Back Soon!</h2>
<h3>Enter the name one of the databases above to learn more about it:</h3>
<form action="details.php" method="post">
    <label for="name">Database name:</label>
    <input name="name" id="name" type="text">
    <button type="submit">See Details</button>
 </form>