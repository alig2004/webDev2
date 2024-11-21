<!DOCTYPE html>
<?php
    session_start();
    unset($_SESSION["account"]);
?>
<html>
<head>
<title>Login</title>
</head>
<body>
    <header>
        <h1>Alexandria Library</h1>
    </header>
    <?php
        //connecting to the database
        require_once "database.php";

        //checking to make sure that all form positions are populated
        if (isset($_POST['Username']) && isset($_POST['Password']))
        {
            
            $u = $conn -> real_escape_string(htmlentities($_POST['Username']));
            $p = $conn -> real_escape_string(htmlentities($_POST['Password']));


            //checking for username and password in users table
            if (strlen($p) != 6) //if password is too short
            {
                echo 'Password is incorrect length';
            }
            else
            {
                //creating the sql statement to find username to users table in library database
                $sql = "SELECT * FROM users WHERE Username = '$u'";

                //storing the row returned by the sql statement
                $result = $conn->query($sql);

                //if row contains a row, check to see if password matches what was input
                if ($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();

                    //if password matches, redirect to menu.php
                    if ($row["Password"] == $p)
                    {
                        $_SESSION["account"] = $u;
                        header("Location: http://localhost/WebD/project/menu.php"); 
                        exit;
                    }
                    else
                    {
                        echo 'Incorrect password';
                    }
                }
                else
                {
                    echo 'Username not found';
                }

            }

        }

        //closing the connection
        $conn->close();
    ?>
    <h2>Login:</h2>
    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="Username" required><br>
        <label>Password:</label><br>
        <input type="password" name="Password" required><br><br>
        <input type="submit" value="Login"/>
    </form>
    <a href="register.php">Don't have an account? Click here to register</a>
</body>
</html>
