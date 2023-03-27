<?php

	$bdd = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');

	$pdoStat = $bdd->prepare('UPDATE sensibilisation set SEN_NOM=:SEN_NOM WHERE SEN_ID=:num LIMIT 1');

	$pdoStat->bindValue(':num',$_POST['numId'],PDO::PARAM_INT);

	$pdoStat->bindValue(':SEN_NOM',$_POST['SEN_NOM'],PDO::PARAM_STR);

	$executeIsOk = $pdoStat->execute();

	header("location:" . $_SERVER['HTTP_REFERER']); 
?>


