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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderID = isset($_POST['order_id']) ? $_POST['order_id'] : null; //gets what user inputted

    $deleteOrderQuery = "DELETE FROM Orders WHERE OrderID = ?";
    $deleteOrderStmt = $conn->prepare($deleteOrderQuery);
    $deleteOrderStmt->bind_param("i", $orderID);

    if ($deleteOrderStmt->execute()) {
        echo "Order canceled successfully!";
    } else {
        echo "Error canceling order: " . $deleteOrderStmt->error;
    }

    $deleteOrderStmt->close();
}

$conn->close();
?>
