<?php
    $dbname = $_POST['name'];   // Get the database name from the POST request
    $conn = new mysqli("localhost", "webuser", "mewtwo", $dbname);   // Connect to the database
    if ($conn->connect_errno) {
        echo "Error: Failed to make a MySQL connection, here is why: ". "<br>";
        echo "Errno: " . $conn->connect_errno . "\n";
        echo "Error: " . $conn->connect_error . "\n";
        exit; // Quit this PHP script if the connection fails.
    }
    $tablelist = "SHOW tables";      // Gets a list of all tables in the database
    $result = $conn->query($tablelist);
    echo "<h2>Tables in $dbname:</h2>";
    while ($tablename = $result->fetch_array()) { 
        echo $tablename[0] . "<br>";     // Displays the list of tables
    }

    $conn->close();
?>