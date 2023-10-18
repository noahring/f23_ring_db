<html>
    <head>
    <title>PHP Test Page</title>
    </head>
    <body> 
        <h2>Tutorial Start</h2>
        <?php echo "Hello world!"; ?>
        <br>
        <!--------------------------------------------------------------------->
        <h2>Something Useful</h2>
        <?php echo $_SERVER['HTTP_USER_AGENT']; ?>
        <br>
        <?php if (strpos($_SERVER['HTTP_USER_AGENT'],'Firefox') !== false) {
            echo 'You are using Firefox.';
        }  
        ?>
        <br>
        <?php if (strpos($_SERVER['HTTP_USER_AGENT'],'Firefox') !== false){
        ?>
        <h3>strpos() returned a valid index</h3>
        <p> You are using Firefox.</p>
        <?php
        } else {
        ?>
        <p> You are not using Firefox.</p>
        <?php
        }
        ?>
        <!--------------------------------------------------------------------->
        <h2>Dealing With Forms</h2>
        <form action="action.php" method="post">
            <label for="name">Your name:</label>
            <input name="name" id="name" type="text">

            <label for="age">Your age:</label>
            <input name="age" id="age" type="number">
            <button type="submit">Submit</button>
    </form>
    </body>
</html>