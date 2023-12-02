<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $config = parse_ini_file('/home/noahring/mysql.ini');
    $conn = new mysqli(
            $config['mysqli.default_host'],
            $config['mysqli.default_user'],
            $config['mysqli.default_pw']);

    if ($conn->connect_errno) {
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . 
        $conn->connect_error;
        exit();
    }

    $conn->select_db('robo_rest_fall_2023');

    $menuQuery = "SELECT DishName, DishPrice FROM Dishes"; //for menu table
    $menuResult = $conn->query($menuQuery);

    if (!$menuResult) {
        echo "Error fetching menu items: " . $conn->error;
        exit;
    }

    $pendingOrders = "SELECT * FROM Orders WHERE OrderDeliveryTime IS NULL"; //for pending orders table
    $result = $conn->query($pendingOrders);

    if (!$result) {
        echo "Error fetching orders: " . $conn->error;
        exit;
    }
?>

<!DOCTYPE html>
<head>
    <title>Robotic Restaurant</title>
</head>
<body>
<h1>Welcome to Alice's Robotic Restaurant</h1>
<p>You can grep anything you want from Alice's Restaurant.</p>
<form action="send_order.php" method="POST">
<h2>Menu</h2>
<table>
            <tr>
                <th>Quantity</th>
                <th>Item</th>
                <th>Price</th>
            </tr>

            <?php
            while ($row = $menuResult->fetch_assoc()) {
                $dishID = isset($row['DishID']) ? $row['DishID'] : null;                
                $dishName = $row['DishName'];
                $dishPrice = $row['DishPrice'];

                echo "<tr>";
                echo "<td><input type='number' name='quantity[$dishID]' value='0' min='0'></td>";
                echo "<td>$dishName</td>";
                echo "<td>$dishPrice</td>";
                echo "</tr>";
            }
            ?>
</table>
<table>
    <thead>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: right">Name:</td>
            <td><input type="text" name="cust_name" required/></td>
        </tr>
        <tr>
            <td style="text-align: right">Latitude:</td>
            <td><input type="text" name="cust_lat" pattern="[0-9]+(\.[0-9])?" title="Enter a valid decimal number" required/></td>
        </tr>
        <tr>
            <td style="text-align: right">Longitude:</td>
            <td><input type="text" name="cust_lon" pattern="[0-9]+(\.[0-9])?" title="Enter a valid decimal number" required/></td>
        </tr>
    </tbody>
</table>
<input type="submit" value="Place Order"/>
</form>
<h2>Cancel an Order</h2>
<form action="cancel_order.php" method="POST">
<table>
    <thead>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: right">Order ID:</td>
            <td><input type="text" name="order_id"/></td>
        </tr>
    </tbody>
</table>
<input type="submit" value="Delete Order"/>
</form>
<h2>Pending Orders</h2>
<table>
    <thead>
    <tr>
        <th>OrderID</th>
        <th>CustomerID</th>
        <th>OrderSubmissionTime</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['OrderID']}</td>";
        echo "<td>{$row['CustomerID']}</td>";
        echo "<td>{$row['OrderSubmissionTime']}</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>

