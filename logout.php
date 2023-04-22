<?php

session_start();

require("inc/authenticate.php");

if(isset($_SESSION["name"]))
{
    unset($_SESSION["email"]);
    unset($_SESSION["name"]);
    unset($_SESSION["is_admin"]);
}

header("Location: /");
