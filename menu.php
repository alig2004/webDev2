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
            <label>Title:</label><br>
            <input type="text" name="title"><br>
            <label>Author:</label><br>
            <input type="text" name="auth"><br><br>
            <select name="category" id="category">
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
        </form>
    </body>
    <?php
            /*
            - make a search bar
            - access books via searchbar (select statements with LIKE??)
            - access categories via dropdown menu
            - display books matching search (max 5 at a time)
            - button to reserve each book
            - logout
            */

            //closing the connection
            $conn->close();
    ?>
</html>
