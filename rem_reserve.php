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

        //checking to make sure that all form positions are populated
        if ( isset($_POST['delete']) && isset($_POST['ISBN']))
        {
            
            $isbn = $conn -> real_escape_string($_POST['ISBN']);

            //deleting row from reserved table
            $sql1 = "DELETE FROM reserved WHERE ISBN='$isbn'";

            if ($conn->query($sql1) === True)
            {
                //changing Reserve in books table from 'Y' to 'N'
                $sql2 = "UPDATE books SET Reserve='N' WHERE ISBN='$isbn'";

                if ($conn->query($sql2) === True)
                {
                    header("Location: http://localhost/WebD/project/reserve.php");
                }
                else
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
               
                
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        //getting ISBN of book to be removed from reserved
        $isbn = $conn -> real_escape_string($_GET['isbn']);

        $sql3 = "SELECT * from reserved WHERE ISBN='$isbn'";
        $result3 = $conn -> query($sql3);
        $row3 = $result3->fetch_assoc();

        //displaying title of books
        $sql4 = "SELECT * FROM books WHERE ISBN='$isbn'";
        $result4 = $conn->query($sql4);
        $row4 = $result4->fetch_assoc();

        echo "<p>Remove reservation from ". $row3['ISBN'] ." " . $row4['BookTitle'] . "?</p><br>";
        echo ('<form method="post"><input type="hidden" ');
        echo ('name="ISBN" value="'.htmlentities($row3['ISBN']).'"><br>');
        echo ('<input type="submit" value="Remove" name="delete">');
        echo ('<a href="reserve.php">Cancel</a>');
        echo ("<br></form><br>");

        //closing the connection
        $conn->close();
        
    }
?>
<html>
    <head>
        <title>Alexandria Library</title>
    </head>
    <body>
        <a href="http://localhost/WebD/project/menu.php">Menu</a>
    </body>
    <?php
        /*
        - link back to menu page
        - logout
        */
    ?>
</html>