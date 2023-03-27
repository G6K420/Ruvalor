<?php

	$bdd = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');

	$pdoStat = $bdd->prepare('UPDATE formation set FOR_NOM=:FOR_NOM WHERE FOR_ID=:num LIMIT 1');

	$pdoStat->bindValue(':num',$_POST['numId'],PDO::PARAM_INT);

	$pdoStat->bindValue(':FOR_NOM',$_POST['FOR_NOM'],PDO::PARAM_STR);

	$executeIsOk = $pdoStat->execute();

	header("location:" . $_SERVER['HTTP_REFERER']); 
?>


