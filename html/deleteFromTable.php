<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>

<?php
    //Connect to the database
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

    $conn->select_db('instrument_rentals');
?> 
<?php
    $del_stmt = $conn->prepare("DELETE FROM instruments WHERE instrument_id = ?");
    $del_stmt->bind_param("i", $id);
    $result = $conn->query("SELECT * FROM instruments");
    $resrows = $result->fetch_all();    
?>

<?php
    for ($i = 0; $i < $result->num_rows; $i++) {
        $id = $resrows[$i][0];
        $key = "checkbox" . $id;
        if (isset($_POST[$key]) && !$del_stmt->execute()) {
            echo $conn->error;
        }
    }   
?>

<?php
// Redirects back to page
header('Location: manageInstruments.php');

?>