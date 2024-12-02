<!DOCTYPE HTML>
<?php
    session_start();
    if (!(isset($_SESSION["account"]))) //if they aren't logged in, redirect to login page
    {
        header("Location: http://localhost/WebD/project/index.php");
    }
    else
    {
        //destroy the session and return to index
        session_destroy();
        header("Location: http://localhost/WebD/project/index.php");
    }
?>