<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
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
        <div class="register_form">
            <h2>Register:</h2>
            <form method="post">
                <label>Username:</label><br>
                <input type="text" name="Username" required><br><br>
                <label>Password:</label><br>
                <input type="password" name="Password" required><br><br>
                <label>Confirm password:</label><br>
                <input type="password" name="ConfirmPassword" required><br><br>
                <label>First name:</label><br>
                <input type="text" name="FirstName" required><br><br>
                <label>Last name:</label><br>
                <input type="text" name="LastName" required><br><br>
                <label>Address line 1:</label><br>
                <input type="text" name="AddressLine1" required><br><br>
                <label>Address line 2:</label><br>
                <input type="text" name="AddressLine2" required><br><br>
                <label>City:</label><br>
                <input type="text" name="City" required><br><br>
                <label>Telephone number:</label><br>
                <input type="number" name="Telephone" required><br><br>
                <label>Mobile number:</label><br>
                <input type="number" name="Mobile" required><br><br>
                <input type="submit" value="Register"/>
            </form>
            <?php
                //connecting to the database
                require_once "database.php";

                //checking to make sure that all form positions are populated
                if ( isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['ConfirmPassword']) && isset($_POST['FirstName']) && isset($_POST['LastName']) && isset($_POST['AddressLine1']) && isset($_POST['AddressLine2']) && isset($_POST['City']) && isset($_POST['Telephone'])&& isset($_POST['Mobile']))
                {
                    
                    $u = $conn -> real_escape_string(htmlentities($_POST['Username']));
                    $p = $conn -> real_escape_string(htmlentities($_POST['Password']));
                    $pc = $conn -> real_escape_string(htmlentities($_POST['ConfirmPassword']));
                    $f = $conn -> real_escape_string(htmlentities($_POST['FirstName']));
                    $l = $conn -> real_escape_string(htmlentities($_POST['LastName']));
                    $a1 = $conn -> real_escape_string(htmlentities($_POST['AddressLine1']));
                    $a2 = $conn -> real_escape_string(htmlentities($_POST['AddressLine2']));
                    $c = $conn -> real_escape_string(htmlentities($_POST['City']));
                    $t = $conn -> real_escape_string(htmlentities($_POST['Telephone']));
                    $m = $conn -> real_escape_string(htmlentities($_POST['Mobile']));


                    //inserting into users table
                    if ($p != $pc) //if passwords don't match
                    {
                        echo '<p class="error">Password does not match</p>';
                    }
                    else if (strlen($p) != 6) //if password is too short
                    {
                        echo '<p class="error">Password is incorrect length (must be 6 characters)</p>';
                    }
                    else
                    {
                        if (strlen($m) != 10)
                        {
                            echo '<p class="error">Mobile number is incorrect length (must be 10 digits)<p>';
                        }
                        else //if password is fine, check if username is already in database 
                        {
                            //creating the sql statement to find username to users table in library database
                            $userCheck = "SELECT * FROM users WHERE Username = '$u'";

                            //storing the row returned by the sql statement
                            $resultCheck = $conn->query($userCheck);

                            //if row contains a row, check to see if password matches what was input
                            if ($resultCheck->num_rows > 0)
                            {
                                echo '<p class="error">This username is already in use, please try a different username</p>';
                            }
                            else
                            {

                                //creating the sql statement to insert new user to users table in library database
                                $insert = "INSERT INTO users (Username, Password, FirstName, LastName, AddressLine1, AddressLine2, City, Telephone, Mobile)  VALUES ('$u', '$p', '$f', '$l', '$a1', '$a2', '$c', '$t', '$m')";

                                //if sql query is successfully carried out
                                if ($conn->query($insert) === True)
                                {
                                    //redirect user back to login
                                    header("Location: http://localhost/WebD/project/index.php"); 
                                }
                                else
                                {
                                    echo "Error: " . $insert . "<br>" . $conn->error;
                                }
            
                            }
                            
                        }

                    }

                }

                //closing the connection
                $conn->close();
            ?>
            <br>
            <a href="index.php">Already have an account? Click here to login</a>
        </div>
        <footer class="scroll_footer">
            <p><i>Copyright Alison Gleeson, 2024</i></p>
        </footer>
    </body>
</html>
