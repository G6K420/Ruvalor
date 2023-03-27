<?php

	$bdd = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');

	$pdoStat = $bdd->prepare('UPDATE metier set MET_NOM=:MET_NOM WHERE MET_ID=:num LIMIT 1');

	$pdoStat->bindValue(':num',$_POST['numId'],PDO::PARAM_INT);

	$pdoStat->bindValue(':MET_NOM',$_POST['MET_NOM'],PDO::PARAM_STR);

	$executeIsOk = $pdoStat->execute();

	header("location:" . $_SERVER['HTTP_REFERER']); 
?>


