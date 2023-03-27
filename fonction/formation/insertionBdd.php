<?php 

	include "../../bdd/bdd.php";

	var_dump($_POST);
    
    $select=$bdd->SELECTALL("formation");
    $doublon=false;

    $postFormation = $_POST['nom'];
    $formation = str_replace(' ', '', $postFormation);

    if(isset($_POST['nom'])){
    	
        foreach($select as $key){

            $bddformation = $key['FOR_NOM'];
            $bddform = str_replace(' ', '', $bddformation);

            if($bddform == $formation){
            	$doublon=true;
            }
        }
        if($doublon==true){
            echo ' <script>alert("Cette formation existe déjà");window.history.back() ;</script>';
        }
        else {
            $data= array(
            	"FOR_NOM" => $_POST['nom'],
            	);
			$bdd->INSERT("formation",$data);
			header("location:" . $_SERVER['HTTP_REFERER']); 
        }
    }
    else{
        echo ' <script>alert("Il faut compléter tous les champs");window.history.back() ;</script>';
    }
	
?> 