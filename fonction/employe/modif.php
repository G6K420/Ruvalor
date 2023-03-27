<?php

	$bdd = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');

	$postSecu = $_POST['EMP_SECU'];
    $secu = str_replace(' ', '', $postSecu);

	$pdoStat = $bdd->prepare('UPDATE employe set EMP_NOM=:EMP_NOM, EMP_PRENOM=:EMP_PRENOM, EMP_SECU=:EMP_SECU WHERE EMP_ID=:num LIMIT 1');

	$pdoStat->bindValue(':num',$_POST['numId'],PDO::PARAM_INT);

	$pdoStat->bindValue(':EMP_NOM',$_POST['EMP_NOM'],PDO::PARAM_STR);

	$pdoStat->bindValue(':EMP_PRENOM',$_POST['EMP_PRENOM'],PDO::PARAM_STR);

	$pdoStat->bindValue(':EMP_SECU',$secu,PDO::PARAM_STR);

	$executeIsOk = $pdoStat->execute();

	header("location:" . $_SERVER['HTTP_REFERER']); 
?>


