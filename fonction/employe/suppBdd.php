<?php
	$bdd = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');

	$pdoStat = $bdd->prepare('DELETE FROM employe WHERE EMP_ID=:id LIMIT 1');

	$pdoStat->bindValue(':id', $_GET['numId'], PDO::PARAM_INT);

	$executeIsOk = $pdoStat->execute();

	header("location:" . $_SERVER['HTTP_REFERER']); 
?>