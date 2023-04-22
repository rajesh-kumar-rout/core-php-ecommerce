<?php 

function authenticate()
{
    if(!isset($_SESSION["email"]))
    {
        header("Location: /admin/login.php");
        die();
    }
}