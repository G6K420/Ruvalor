<?php

	$id = $_GET['numId'];

	unlink("../../img/photo/$id.jpg");

	header("location:" . $_SERVER['HTTP_REFERER']); 
?>