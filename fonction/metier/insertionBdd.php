<?php 

	include "../../bdd/bdd.php";

	var_dump($_POST);
    
    $select=$bdd->SELECTALL("metier");
    $doublon=false;

    $postMetier = $_POST['nom'];
    $metier = str_replace(' ', '', $postMetier);

    if(isset($_POST['nom'])){        
    	
        foreach($select as $key){

            $bddmetier = $key['MET_NOM'];
            $bddmet = str_replace(' ', '', $bddmetier);

            if($bddmet == $metier){
            	$doublonNum=true;
            }
        }
        if($doublonNum==true){
            echo ' <script>alert("Ce métier existe déjà");window.history.back() ;</script>';
        }
        else {

            $data= array(
            	"MET_NOM" => $_POST['nom'],
            	);
			$bdd->INSERT("metier",$data);
			header("location:" . $_SERVER['HTTP_REFERER']); 
        }
    }
    else{
        echo ' <script>alert("Il faut compléter tous les champs");window.history.back() ;</script>';
    }
	
?> 