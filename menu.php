<!DOCTYPE html>
<?php
    session_start();
    if (!(isset($_SESSION["account"]))) //if they aren't logged in, redirect to login page
    {
        header("Location: http://localhost/WebD/project/index.php");
    }
    else
    {
        //connecting to the database
        require_once "database.php";
    }
?>
<html>
    <head>
        <title>Alexandria Library</title>
    </head>
    <body>
        
    </body>
    <?php
        /*
        - make a search bar
        - access books via searchbar (select statements with LIKE??)
        - access categories via dropdown menu
        - display books matching search (max 5 at a time)
        */

        //closing the connection
        $conn->close();
    ?>
</html>
