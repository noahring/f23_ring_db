<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$config = parse_ini_file('/home/noahring/mysql.ini');
$conn = new mysqli(
    $config['mysqli.default_host'],
    $config['mysqli.default_user'],
    $config['mysqli.default_pw']
);

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    exit();
}

$conn->select_db('robo_rest_fall_2023');

//Getting user input from the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = $_POST['cust_name'];
    $customerLat = $_POST['cust_lat'];
    $customerLon = $_POST['cust_lon'];

    $insertOrderQuery = "INSERT INTO Orders (FranchiseID, CustomerID, DeliveryLocationLat, DeliveryLocationLon) VALUES (?, ?, ?, ?)";
    $franchiseID = 1;  
    $customerID = 1;  //default customer and franshiseID

    $deliveryLocationLat = $_POST['cust_lat'];
    $deliveryLocationLon = $_POST['cust_lon'];

    $insertOrderStmt = $conn->prepare($insertOrderQuery);
    $insertOrderStmt->bind_param("iidd", $franchiseID, $customerID, $deliveryLocationLat, $deliveryLocationLon);

    if ($insertOrderStmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error placing order: " . $insertOrderStmt->error;
    }

    $insertOrderStmt->close();
}
?>

