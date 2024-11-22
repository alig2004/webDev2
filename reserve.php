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

        $user = $_SESSION["account"];

        //displaying reserved table
        $sql1 = "SELECT * FROM reserved WHERE username='$user'";
        $result1 = $conn->query($sql1);


        //outputting data from each row
        if ($result1->num_rows >0)
        {
            echo "<table border = '1'>";
            //row titles
            echo "<tr><td>";
            echo "Book Title";
            echo "</td><td>";
            echo "Author";
            echo "</td><td>";
            echo  "ISBN";
            echo "</td><td>";
            echo "Date Reserved";
            echo "</tr>";
            
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
                    echo "<tr><td>";
                    echo (htmlentities($row2["BookTitle"]));
                    echo "</td><td>";
                    echo (htmlentities($row2["Author"]));
                    echo "</td><td>";
                    echo (htmlentities($row1["ISBN"]));
                    echo "</td><td>";
                    echo (htmlentities($row1["ReservedDate"]));
                    //echo "</td><td>";
                    //echo ('<a href="update.php?id='.htmlentities($row["ProductID"]).'">Edit</a> / ');
                    //echo ('<a href="delete.php?id='.htmlentities($row["ProductID"]).'">Delete</a>');
                    echo "</tr>\n";
                }
                
            }
        }
        else
        {
            echo "You Don't Have Any Books Reserved!";
        }
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
        - retrieve data from reserved
        - remove from reserved if desired (should also change marker in books table)
        - link back to menu page
        - logout
        */

        //closing the connection
        $conn->close();
    ?>
</html>