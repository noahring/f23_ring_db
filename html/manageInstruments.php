<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<h1>Delete Instruments<br></h1>

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

    $query = "SELECT * FROM instruments";
    $result = $conn->query($query);


    
?>

<?php
function result_to_html_table($result) {
        // $result is a mysqli result object. This function formats the object as an
        // HTML table. Note that there is no return, simply call this function at the 
        // position in your page where you would like the table to be located.

        $result_body = $result->fetch_all();
        $num_rows = $result->num_rows;
        $num_cols = $result->field_count;
        $fields = $result->fetch_fields();
        ?>
        <!-- Description of table - - - - - - - - - - - - - - - - - - - - -->
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
        <?php
 } 

result_to_html_table($result);

?>