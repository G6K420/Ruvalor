<?php 

	include "../../bdd/bdd.php";

	var_dump($_POST);
    
    $select=$bdd->SELECTALL("employe");
    $doublon=false;

    $postSecu = $_POST['secu'];
    $secu = str_replace(' ', '', $postSecu);

    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($secu)){
    	
        foreach($select as $key){

            $bddsecurite = $key['EMP_SECU'];
            $bddsecu = str_replace(' ', '', $bddsecurite);

            if($bddsecu == $secu){
            	$doublon=true;
            }
        }
        if($doublon==true){
            echo ' <script>alert("Le numéro de sécurité sociale existe déjà");window.history.back() ;</script>';
        }
        else {
            /*$numero = $_POST['num'];

            $numero = preg_replace( '/[^0-9]|[+33]/', '', $subject );

            if(strlen($numero)>10 AND substr($numero, 0, 3)!="33"){
              $numero=substr($numero,0,-(strlen($numero)-10));
            }

            if (substr($numero, 0, 1)==0){
              $numero=preg_replace('/^0/','33',$numero);
            }
            else if (substr($numero, 0, 3)=="+33"){
                $numero=1;
            }
            else $numero='33' . $numero;*/

            $data= array(
            	"EMP_NOM" => $_POST['nom'],
            	"EMP_PRENOM" => $_POST['prenom'],
            	"EMP_SECU" => $secu,
            	);
			$bdd->INSERT("employe",$data);
			header("location:" . $_SERVER['HTTP_REFERER']); 
        }
    }
    else{
        echo ' <script>alert("Il faut compléter tous les champs");window.history.back() ;</script>';
    }
	
?> 