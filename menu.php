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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="library.css">
    </head>
    <body>
    <header>
        <h1>Alexandria Library</h1>
    </header>
    <navbar>
        <nav>
            <a href="menu.php">Search</a>
            <a href="reserve.php">My Reservations</a>
            <a href="logout.php">Log Out</a>
        </nav>
    </navbar>
    <div class="search_form">
        <h2>Search:</h2>
        <p>To see our entire catalogue, press 'Search' without filling in the form.</p>
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
    </div>
        <?php
            //checking to make sure that all form positions are populated
            if (isset($_POST['title']) && isset($_POST['auth']) && isset($_POST['category']))
            {
                $t = $conn -> real_escape_string(htmlentities($_POST['title']));
                $a = $conn -> real_escape_string(htmlentities($_POST['auth']));
                $c = $conn -> real_escape_string(htmlentities($_POST['category']));
                $i = 0;

                header("Location: http://localhost/WebD/project/display.php?t=".$t."&a=".$a."&c=".$c."&i=".$i."");
            }
        ?>
        <footer class="common_footer">
            <p><i>Copyright Alison Gleeson, 2024</i></p>
        </footer>
    </body>
    <?php
        $conn->close();
    ?>
</html>
