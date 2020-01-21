<?php
	session_start();
    
    if (isset($_SESSION['login']))
        $_SESSION['login'] = null;
    
    header("Location: index.php");
?>
