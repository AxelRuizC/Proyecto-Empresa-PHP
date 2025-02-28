<?php
session_start();

unset($_SESSION['verificado']);

header("Location: login.php");

?>