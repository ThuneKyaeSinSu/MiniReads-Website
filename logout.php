<?php
    // Destroy the "user" cookie
    setcookie("user", "", time() - 3600, "/");
    setcookie("visit", "", time() - 3600, "/");
    header("Location: index.php"); 
    exit();
?>
