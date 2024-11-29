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
            $account = $_SESSION["account"];
            $date = date("Y-m-d");

            //adding row to reserved table
            $sql1 = "INSERT INTO reserved (ISBN, Username, ReservedDate) VALUES ('$isbn', '$account', '$date')";

            if ($conn->query($sql1) === True)
            {
                //changing Reserve in books table from 'N' to 'Y'
                $sql2 = "UPDATE books SET Reserve='Y' WHERE ISBN='$isbn'";

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

        //getting ISBN of book to be reserved
        $isbn = $conn -> real_escape_string($_GET['isbn']);

        //displaying title of books
        $sql3 = "SELECT * FROM books WHERE ISBN='$isbn'";
        $result3 = $conn->query($sql3);
        $row3 = $result3->fetch_assoc();

        echo "<p>Reserve ". $row3['ISBN'] ." " . $row3['BookTitle'] . "?</p><br>";
        echo ('<form method="post"><input type="hidden" ');
        echo ('name="ISBN" value="'.htmlentities($row3['ISBN']).'"><br>');
        echo ('<input type="submit" value="Reserve" name="reserve">');
        echo ('<a href="menu.php">Cancel</a>');
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
