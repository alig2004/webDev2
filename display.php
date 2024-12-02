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
        <header>
            <h1>Alexandria Library</h1>
            <navbar>
                <a href="menu.php">Search</a>
                <a href="reserve.php">My Reservations</a>
                <a href="logout.php">Log Out</a>
            </navbar>
        </header>
        <?php
            $t = $conn -> real_escape_string($_GET['t']);
            $a = $conn -> real_escape_string($_GET['a']);
            $c = $conn -> real_escape_string($_GET['c']);
            $i = $conn -> real_escape_string($_GET['i']);
            

            //if we are showing the first set of 5 rows, set $more to True
            $first = False;
            if ($i == 0)
            {
                $first = True;
            }


            //creating the sql statements to find books matching users search
            if ($c == 0)  //if search includes title and/or author but no category
            {
                $search = "SELECT * FROM books WHERE BookTitle LIKE '%$t%' AND Author LIKE '%$a%'";

                //storing the row returned by the sql statement
                $result1 = $conn->query($search);

                if ($result1->num_rows > 0)
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

                    //if number of rows returned is less than 5
                    if ($result1->num_rows <= 5)
                    {
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
                    else //if number of rows returned is greater than 5
                    {
                        $amount = $result1->num_rows;
                        $count = 0;

                        //iterating through rows from sql1 query
                        while(($row1 = $result1->fetch_assoc()))
                        {
                            $id = $conn -> real_escape_string(htmlentities($row1['Category']));
                            $catFind = "SELECT CategoryDesc FROM category WHERE CategoryID='$id'";
                            $result2 = $conn->query($catFind);

                            //creating an array containing each row
                            while($row2 = $result2->fetch_assoc())
                            {
                                $rows[$count] = array(htmlentities($row1["ISBN"]), htmlentities($row1["BookTitle"]), htmlentities($row1["Author"]), htmlentities($row1["Edition"]), htmlentities($row1["Year"]), htmlentities($row2["CategoryDesc"]), $row1["Reserve"]);

                                $count++;
                            }

                        }

                        //looping through to display each row
                        $j = $i + 5;

                        //while $i is less than the total amount of rows returned by the query and less than itself plus 5 
                        //-> only displaying 5 rows at a time
                        while (($i < $amount) && ($i < $j)) 
                        {
                            //displaying the data
                            echo "<tr>";
                            echo "<td>".$rows[$i][0]."</td>";
                            echo "<td>".$rows[$i][1]."</td>";
                            echo "<td>".$rows[$i][2]."</td>";
                            echo "<td>".$rows[$i][3]."</td>";
                            echo "<td>".$rows[$i][4]."</td>";
                            echo "<td>".$rows[$i][5]."</td>";
                            echo "</td><td>";
                            if ($rows[$i][6] == 'Y')
                            {
                                echo ('Already Reserved');
                            }
                            else
                            {
                                echo ('<a href="add_reserve.php?isbn='.$rows[$i][0].'">Reserve</a>');
                            }
                            echo "</tr>";
                            

                            $i++;
                        }

                        echo "</table>";

                        //if 5 rows have been displayed 
                        if ($first == False)
                        {
                            $prev = $i - $j;
                            if ($prev < 0)
                            {
                                $prev = 0;
                                echo '<a href="display.php?t='.$t.'&a='.$a.'&c='.$c.'&i='.$prev.'">First Page</a>';
                            }
                            else
                            {
                                echo '<a href="display.php?t='.$t.'&a='.$a.'&c='.$c.'&i='.$prev.'">Previous Page</a>';
                            }
                            
                        }

                        if ($amount - ($i - 5) > 5)
                        {
                            echo '<a href="display.php?t='.$t.'&a='.$a.'&c='.$c.'&i='.$i.'">Next Page</a>';
                        }
                        
                        
                    }
                }
                else
                {
                    echo "No books matching search found. Try using different search terms.";
                }
            }
            else  //if search includes title and/or author and category
            {
                $search = "SELECT * FROM books WHERE BookTitle LIKE '%$t%' AND Author LIKE '%$a%' AND Category = '$c'";

                //storing the row returned by the sql statement
                $result1 = $conn->query($search);

                if ($result1->num_rows > 0)
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

                    //if number of rows returned is less than 5
                    if ($result1->num_rows <= 5)
                    {
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
                    else //if number of rows returned is greater than 5
                    {
                        $amount = $result1->num_rows;
                        $count = 0;

                        //iterating through rows from sql1 query
                        while(($row1 = $result1->fetch_assoc()))
                        {
                            $id = $conn -> real_escape_string(htmlentities($row1['Category']));
                            $catFind = "SELECT CategoryDesc FROM category WHERE CategoryID='$id'";
                            $result2 = $conn->query($catFind);

                            //creating an array containing each row
                            while($row2 = $result2->fetch_assoc())
                            {
                                $rows[$count] = array(htmlentities($row1["ISBN"]), htmlentities($row1["BookTitle"]), htmlentities($row1["Author"]), htmlentities($row1["Edition"]), htmlentities($row1["Year"]), htmlentities($row2["CategoryDesc"]), $row1["Reserve"]);

                                $count++;
                            }

                        }

                        //looping through to display each row
                        $j = $i + 5;

                        //while $i is less than the total amount of rows returned by the query and less than itself plus 5 
                        //-> only displaying 5 rows at a time
                        while (($i < $amount) && ($i < $j)) 
                        {
                            //displaying the data
                            echo "<tr>";
                            echo "<td>".$rows[$i][0]."</td>";
                            echo "<td>".$rows[$i][1]."</td>";
                            echo "<td>".$rows[$i][2]."</td>";
                            echo "<td>".$rows[$i][3]."</td>";
                            echo "<td>".$rows[$i][4]."</td>";
                            echo "<td>".$rows[$i][5]."</td>";
                            echo "</td><td>";
                            if ($rows[$i][6] == 'Y')
                            {
                                echo ('Already Reserved');
                            }
                            else
                            {
                                echo ('<a href="add_reserve.php?isbn='.$rows[$i][0].'">Reserve</a>');
                            }
                            echo "</tr>";
                            

                            $i++;
                        }

                        echo "</table>";

                        //if 5 rows have been displayed 
                        if ($first == False)
                        {
                            $prev = $i - $j;
                            if ($prev < 0)
                            {
                                $prev = 0;
                                echo '<a href="display.php?t='.$t.'&a='.$a.'&c='.$c.'&i='.$prev.'">First Page</a>';
                            }
                            else
                            {
                                echo '<a href="display.php?t='.$t.'&a='.$a.'&c='.$c.'&i='.$prev.'">Previous Page</a>';
                            }
                            
                        }

                        if ($amount - ($i - 5) > 5)
                        {
                            echo '<a href="display.php?t='.$t.'&a='.$a.'&c='.$c.'&i='.$i.'">Next Page</a>';
                        }
                        
                        
                    }
                }
                else
                {
                    echo "No books matching search found.";
                }
            }

        ?>
        <footer>
            <p><i>Copyright Alison Gleeson, 2024</i></p>
        </footer>
    </body>
    <?php
        $conn->close();
    ?>
</html>