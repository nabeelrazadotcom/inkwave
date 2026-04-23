<?php

if (!($_SESSION['Loggedin'])) {
    header("Location: login_form.php");
    exit();
}

session_start();

session_unset();

session_destroy();

header("Location: login_form.php");
exit();
