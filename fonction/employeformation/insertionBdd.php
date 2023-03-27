<?php 

	include "../../bdd/bdd.php";

    $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');
    $doublon=false;

    $select=$bdd->SELECTALL("employeformation");

    if ($_POST['newFormation']) {

        $req = $connect->prepare('Select FOR_ID as idFormation from formation where FOR_NOM = ?');
        $req->execute(array($_POST['newFormation']));

        $idEmp = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idFor = $donnees ['idFormation'];
        }
            
        
        if($idFor==true){

            if (empty($_POST['date']) && !empty($_POST['dateFin'])) {
        	
                foreach($select as $key){
                    if (($key['EMP_ID'] == $idEmp) && ($key['FOR_ID'] == $idFor) && ($key['EMPFOR_DATEFIN'] == $_POST['dateFin'])) {
                    	$doublon=true;
                    }
                }
                if($doublon==true){
                    echo ' <script>alert("Cette formation est déjà attribué à cet employé à cette date");window.history.back() ;</script>';
                }

                else {
                    $data= array(
                    	"EMP_ID" => $idEmp,
                    	"FOR_ID" => $idFor,
                        "EMPFOR_DATEFIN" => $_POST['dateFin'],
                    	);
        			$bdd->INSERT("employeformation",$data);
        			header("location:" . $_SERVER['HTTP_REFERER']); 
                }
            }

            if (!empty($_POST['date']) && empty($_POST['dateFin'])) {
            
                foreach($select as $key){
                    if (($key['EMP_ID'] == $idEmp) && ($key['FOR_ID'] == $idFor) && ($key['EMPFOR_DATE'] == $_POST['date'])) {
                        $doublon=true;
                    }
                }
                if($doublon==true){
                    echo ' <script>alert("Cette formation est déjà attribué à cet employé à cette date");window.history.back() ;</script>';
                }

                else {
                    $data= array(
                        "EMP_ID" => $idEmp,
                        "FOR_ID" => $idFor,
                        "EMPFOR_DATE" => $_POST['date'],
                        );
                    $bdd->INSERT("employeformation",$data);
                    header("location:" . $_SERVER['HTTP_REFERER']); 
                }
            }

            if (!empty($_POST['date']) && !empty($_POST['dateFin'])) {
            
                foreach($select as $key){
                    if (($key['EMP_ID'] == $idEmp) && ($key['FOR_ID'] == $idFor) && ($key['EMPFOR_DATE'] == $_POST['date']) && ($key['EMPFOR_DATEFIN'] == $_POST['dateFin'])) {
                        $doublon=true;
                    }
                }
                if($doublon==true){
                    echo ' <script>alert("Cette formation est déjà attribué à cet employé à cette date");window.history.back() ;</script>';
                }

                else {
                    $data= array(
                        "EMP_ID" => $idEmp,
                        "FOR_ID" => $idFor,
                        "EMPFOR_DATE" => $_POST['date'],
                        "EMPFOR_DATEFIN" => $_POST['dateFin'],
                        );
                    $bdd->INSERT("employeformation",$data);
                    header("location:" . $_SERVER['HTTP_REFERER']); 
                }
            }

            else {
                echo ' <script>alert("Il faut renseigner au moins une date");window.history.back() ;</script>';
            }  
        }
        
        else{
            echo ' <script>alert("Il faut sélectionner une formation");window.history.back() ;</script>';
        }

    }




    if ($_POST['newEmploye']) {

        $infoEmploye = explode("__", $_POST['newEmploye']);

        $req = $connect->prepare('Select EMP_ID as idEmploye from employe where EMP_NOM = ? and EMP_PRENOM = ?');
        $req->execute(array($infoEmploye[0], $infoEmploye[1]));

        $idFor = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idEmp = $donnees ['idEmploye'];
        }
            
        
        if($idEmp==true){

            if (empty($_POST['date']) && !empty($_POST['dateFin'])) {
            
                foreach($select as $key){
                    if (($key['EMP_ID'] == $idEmp) && ($key['FOR_ID'] == $idFor) && ($key['EMPFOR_DATEFIN'] == $_POST['dateFin'])) {
                        $doublon=true;
                    }
                }
                if($doublon==true){
                    echo ' <script>alert("Cette formation est déjà attribué à cet employé à cette date");window.history.back() ;</script>';
                }

                else {
                    $data= array(
                        "EMP_ID" => $idEmp,
                        "FOR_ID" => $idFor,
                        "EMPFOR_DATEFIN" => $_POST['dateFin'],
                        );
                    $bdd->INSERT("employeformation",$data);
                    header("location:" . $_SERVER['HTTP_REFERER']); 
                }
            }

            if (!empty($_POST['date']) && empty($_POST['dateFin'])) {
            
                foreach($select as $key){
                    if (($key['EMP_ID'] == $idEmp) && ($key['FOR_ID'] == $idFor) && ($key['EMPFOR_DATE'] == $_POST['date'])) {
                        $doublon=true;
                    }
                }
                if($doublon==true){
                    echo ' <script>alert("Cette formation est déjà attribué à cet employé à cette date");window.history.back() ;</script>';
                }

                else {
                    $data= array(
                        "EMP_ID" => $idEmp,
                        "FOR_ID" => $idFor,
                        "EMPFOR_DATE" => $_POST['date'],
                        );
                    $bdd->INSERT("employeformation",$data);
                    header("location:" . $_SERVER['HTTP_REFERER']); 
                }
            }

            if (!empty($_POST['date']) && !empty($_POST['dateFin'])) {
            
                foreach($select as $key){
                    if (($key['EMP_ID'] == $idEmp) && ($key['FOR_ID'] == $idFor) && ($key['EMPFOR_DATE'] == $_POST['date']) && ($key['EMPFOR_DATEFIN'] == $_POST['dateFin'])) {
                        $doublon=true;
                    }
                }
                if($doublon==true){
                    echo ' <script>alert("Cette formation est déjà attribué à cet employé à cette date");window.history.back() ;</script>';
                }

                else {
                    $data= array(
                        "EMP_ID" => $idEmp,
                        "FOR_ID" => $idFor,
                        "EMPFOR_DATE" => $_POST['date'],
                        "EMPFOR_DATEFIN" => $_POST['dateFin'],
                        );
                    $bdd->INSERT("employeformation",$data);
                    header("location:" . $_SERVER['HTTP_REFERER']); 
                }
            }

            else {
                echo ' <script>alert("Il faut renseigner au moins une date");window.history.back() ;</script>';
            }  
        }
        
        else{
            echo ' <script>alert("Il faut sélectionner un employe");window.history.back() ;</script>';
        }

    }




    $req->closeCursor();
?> 