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
    <a href="http://localhost/WebD/project/reserve.php">Reserve</a>
    <h2>Search:</h2>
        <form method="post">
            <label>Title:</label>
            <input type="text" name="title">
            <label>Author:</label>
            <input type="text" name="auth">
            <label>Category:</label>
            <select name="category" name="category">
            <option value="0">--------------</option>
                <?php
                    $sql = "SELECT CategoryDesc FROM category";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) 
                    {
                        $cID = 1;
                        while($row = $result->fetch_assoc()) 
                        {
                            echo '<option value="' . $cID . '">' . $row["CategoryDesc"] . '</option>';
                            $cID++;
                        }
                    }
                ?>
            </select>
            <input type="submit" value="Search"/>
            <br><br>
        </form>
        <?php
            //checking to make sure that all form positions are populated
            if (isset($_POST['title']) && isset($_POST['auth']) && isset($_POST['category']))
            {
                
                $t = $conn -> real_escape_string(htmlentities($_POST['title']));
                $a = $conn -> real_escape_string(htmlentities($_POST['auth']));
                $c = $conn -> real_escape_string(htmlentities($_POST['category']));


                //creating the sql statements to find books matching users search
                if ($c == 0)  //if search includes title and author but no category
                {
                    $search = "SELECT * FROM books WHERE BookTitle LIKE '%$t%' AND Author LIKE '%$a%'";

                    //storing the row returned by the sql statement
                    $result1 = $conn->query($search);

                    if ($result1->num_rows  >0)
                    {
                        echo "<table border = '1'>";
                        
                        //row titles
                        echo "<tr>";
                        echo "<td>ISBN</td>";
                        echo "<td>Book Title</td>";
                        echo "<td>Author</td>";
                        echo "<td>Edition</td>";
                        echo "<td>Release Year</td>";
                        echo "<td>Category</td>";
                        echo "<td>Reservation Status</td></tr>";


                        //iterating through rows from sql1 query
                        while($row1 = $result1->fetch_assoc())
                        {
                            $id = $conn -> real_escape_string(htmlentities($row1['Category']));
                            $catFind = "SELECT CategoryDesc FROM category WHERE CategoryID='$id'";
                            $result2 = $conn->query($catFind);

                            while($row2 = $result2->fetch_assoc())
                            {
                                echo "<tr>";
                                echo "<td>".(htmlentities($row1["ISBN"]))."</td>";
                                echo "<td>".(htmlentities($row1["BookTitle"]))."</td>";
                                echo "<td>".(htmlentities($row1["Author"]))."</td>";
                                echo "<td>".(htmlentities($row1["Edition"]))."</td>";
                                echo "<td>".(htmlentities($row1["Year"]))."</td>";
                                echo "<td>".(htmlentities($row2["CategoryDesc"]))."</td>";
                                echo "</td><td>";
                                if ($row1["Reserve"] == 'Y')
                                {
                                    echo ('Already Reserved');
                                }
                                else
                                {
                                    echo ('<a href="add_reserve.php?isbn='.htmlentities($row1["ISBN"]).'">Reserve</a>');
                                }
                                echo "</tr>\n";
                            }
                        }
                    }
                    else
                    {
                        echo "No books matching search found.";
                    }
                }
                else  //if search includes title and author and category
                {
                    $search = "SELECT * FROM books WHERE BookTitle LIKE '%$t%' AND Author LIKE '%$a%' AND Category = '$c'";

                    //storing the row returned by the sql statement
                    $result1 = $conn->query($search);

                    if ($result1->num_rows  >0)
                    {
                        echo "<table border = '1'>";
                        
                        //row titles
                        echo "<tr>";
                        echo "<td>ISBN</td>";
                        echo "<td>Book Title</td>";
                        echo "<td>Author</td>";
                        echo "<td>Edition</td>";
                        echo "<td>Release Year</td>";
                        echo "<td>Category</td>";
                        echo "<td>Reservation Status</td></tr>";


                        //iterating through rows from sql1 query
                        while($row1 = $result1->fetch_assoc())
                        {
                            $id = $conn -> real_escape_string(htmlentities($row1['Category']));
                            $catFind = "SELECT CategoryDesc FROM category WHERE CategoryID='$id'";
                            $result2 = $conn->query($catFind);

                            while($row2 = $result2->fetch_assoc())
                            {
                                echo "<tr>";
                                echo "<td>".(htmlentities($row1["ISBN"]))."</td>";
                                echo "<td>".(htmlentities($row1["BookTitle"]))."</td>";
                                echo "<td>".(htmlentities($row1["Author"]))."</td>";
                                echo "<td>".(htmlentities($row1["Edition"]))."</td>";
                                echo "<td>".(htmlentities($row1["Year"]))."</td>";
                                echo "<td>".(htmlentities($row2["CategoryDesc"]))."</td>";
                                echo "</td><td>";
                                if ($row1["Reserve"] == 'Y')
                                {
                                    echo ('Already Reserved');
                                }
                                else
                                {
                                    echo ('<a href="add_reserve.php?isbn='.htmlentities($row1["ISBN"]).'">Reserve</a>');
                                }
                                echo "</tr>\n";
                            }
                        }
                    }
                    else
                    {
                        echo "No books matching search found.";
                    }
                }


            }

        ?>
        
        
    </body>
    <?php
        /*
        - display books matching search (max 5 at a time)
        - button to reserve each book
        - logout
        */

        //closing the connection
        $conn->close();
    ?>
</html>
