<?php
if (isset($_SESSION['login'])) {
	header("Location: consultaArticulos.php"); 
} else {
	header("Location: login.php");
}
?>
