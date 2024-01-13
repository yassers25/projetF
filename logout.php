<?php
    session_start();
    session_destroy();
    header('Location: /projetf/home.php');
    exit();
?>
