<?php 

	include "../../bdd/bdd.php";

	var_dump($_POST);
    
    $select=$bdd->SELECTALL("sensibilisation");
    $doublon=false;

    $postSensibilisation = $_POST['nom'];
    $sensibilisation = str_replace(' ', '', $postSensibilisation);

    if(isset($_POST['nom'])){
    	
        foreach($select as $key){

            $bddsensibilisation = $key['SEN_NOM'];
            $bddsensi = str_replace(' ', '', $bddsensibilisation);

            if($bddsensi == $sensibilisation){
            	$doublon=true;
            }
        }
        if($doublon==true){
            echo ' <script>alert("Cette sensibilisation existe déjà");window.history.back() ;</script>';
        }
        else {
            $data= array(
            	"SEN_NOM" => $_POST['nom'],
            	);
			$bdd->INSERT("sensibilisation",$data);
			header("location:" . $_SERVER['HTTP_REFERER']); 
        }
    }
    else{
        echo ' <script>alert("Il faut compléter tous les champs");window.history.back() ;</script>';
    }
	
?> 