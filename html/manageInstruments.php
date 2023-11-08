<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<h1>Delete Instruments<br></h1>

<?php
    //Dark and light mode cookie
    $mode = "user_mode";
    $light = "light";
    $dark = "dark";
    $button_pressed = "yes";

    if (!isset($_COOKIE[$mode])) {
        setcookie($mode, $light, 0, "/", "", false, true);
        header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
        exit();
    }

    if (isset($_POST[$button_pressed])){
        $new_mode = $_COOKIE[$mode] == $light ? $dark : $light;
        setcookie($mode, $new_mode, 0, "/", "", false, true);
        header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
        exit();
    }

    //Start the session
    session_start();
    
    if (isset($_POST['logout'])) {
        session_unset(); //ends the session
        header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
        exit();
    }

    if (isset($_POST['username'])) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
        exit();
    }

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

    $query = "SELECT * FROM instruments";
    $result = $conn->query($query);
 
     $result_body = $result->fetch_all();
     $num_rows = $result->num_rows;
     $num_cols = $result->field_count;
     $fields = $result->fetch_fields();
?>
        
    <?php
    if ($_COOKIE[$mode] == $dark) {
    ?>
        <link rel="stylesheet" href="darkmode.css">
    <?php
    } else {
    ?>
        <link rel="stylesheet" href="lightmode.css">
    <?php
    }
    ?>
    <form method=POST>
    <input type="submit" name="<?= $button_pressed ?>" value="Toggle Light/Dark Mode">
    </form> 

    <?php
    if (isset($_SESSION['username'])) {
    ?>
        <p>Welcome <?php echo $_SESSION['username']; ?>!</p>
        <form method=POST>
        <input type="submit" name="logout" value="Logout">
        </form>
    <?php
    } else {
    ?>
        <p>Remember my session:
        <form action="" method=POST>
        <input type=text name='username' placeholder='Enter name...'/>
        <input type=submit value='Remember Me'/>
        </form>
    <?php
    }
    ?>

    <p>This table has <?php echo $num_rows; ?> rows and <?php echo $num_cols; ?> columns.</p>
    <!-- Begin header - - - - - - - - - - - - - - - - - - - - -->
    <form action="deleteFromTable.php" method=POST>
    <table>
        <thead>
        <tr>
        <th>Delete?</th>
        <?php for ($i=0; $i<$num_cols; $i++){ ?>
            <td><b><?php echo $fields[$i]->name; ?></b></td>
        <?php } ?>
        </tr>
        </thead>
        
        <!-- Begin body - - - - - - - - - - - - - - - - - - - - - -->
        <tbody>
        <?php for ($i=0; $i<$num_rows; $i++){ ?>
            <?php $id = $result_body[$i][0]; ?>
            <tr> 
            <td><input type="checkbox" name="checkbox<?php echo $id; ?>" value="<?php echo $id; ?>"></td>    
            <?php for($j=0; $j<$num_cols; $j++){ ?>
                <td><?php echo $result_body[$i][$j]; ?></td>
            <?php } ?>
            </tr>
        <?php } ?>
        </tbody></table>
    <input type="submit" value="Delete Selected" method=POST>
    </form>
    <form action="insertInstruments.php" method=POST>
    <input type="submit" value="Insert New Records" method=POST>
    </form>
    