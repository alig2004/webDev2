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
        <a href="http://localhost/WebD/project/menu.php">Menu</a>
    </body>
    <?php
        /*
        - remove from reserved if desired (should also change marker in books table)
        - link back to menu page
        - logout
        */

        $user = $_SESSION["account"];

        //displaying reserved table
        $sql1 = "SELECT * FROM reserved WHERE username='$user'";
        $result1 = $conn->query($sql1);


        //outputting data from each row
        if ($result1->num_rows >0)
        {
            echo "<table border = '1'>";
            
            //row titles
            echo "<tr>";
            echo "<td>Book Title</td>";
            echo "<td>Author</td>";
            echo "<td>ISBN</td>";
            echo "<td>Date Reserved</td>";
            echo "<td>Reservation Status</td></tr>";

            //iterating through rows from sql1 query
            while($row1 = $result1->fetch_assoc())
            {
                //displaying title and author of books
                $ISBN = $row1["ISBN"];
                $sql2 = "SELECT BookTitle, Author FROM books WHERE ISBN='$ISBN'";
                $result2 = $conn->query($sql2);

                //iterating through rows from sql2 query
                while($row2 = $result2->fetch_assoc())
                {
                    echo "<tr>";
                    echo "<td>".(htmlentities($row2["BookTitle"]))."</td>";
                    echo "<td>".(htmlentities($row2["Author"]))."</td>";
                    echo "<td>".(htmlentities($row1["ISBN"]))."</td>";
                    echo "<td>".(htmlentities($row1["ReservedDate"]))."</td>";
                    echo "</td><td>";
                    echo ('<a href="rem_reserve.php?isbn='.htmlentities($row1["ISBN"]).'">Remove Reservation</a>');
                    echo "</tr>\n";
                }
                
            }
        }
        else
        {
            echo "You Don't Have Any Books Reserved!";
        }

        //closing the connection
        $conn->close();
    ?>
</html>
