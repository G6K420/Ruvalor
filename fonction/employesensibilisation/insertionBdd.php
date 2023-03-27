<?php 

	include "../../bdd/bdd.php";

    $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');
    $doublon=false;

    $select=$bdd->SELECTALL("employesensibilisation");


    if ($_POST['newSensibilisation']) {

        $req = $connect->prepare('Select SEN_ID as idSensibilisation from sensibilisation where SEN_NOM = ?');
        $req->execute(array($_POST['newSensibilisation']));

        $idEmp = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idSen = $donnees ['idSensibilisation'];
        }
        

        if($idSen==true){

            if (!empty($_POST['date'])) {
            
                foreach($select as $key){
                    if (($key['EMP_ID'] == $idEmp) && ($key['SEN_ID'] == $idSen) && ($key['EMPSEN_DATE'] == $_POST['date'])) {
                        $doublon=true;
                    }
                }

                if($doublon==true){
                    echo ' <script>alert("Cette sensibilisation est déjà attribué à cet employé à cette date");window.history.back() ;</script>';
                }

                else {
                    $data= array(
                        "EMP_ID" => $idEmp,
                        "SEN_ID" => $idSen,
                        "EMPSEN_DATE" => $_POST['date'],
                        );
                    $bdd->INSERT("employesensibilisation",$data);
                    header("location:" . $_SERVER['HTTP_REFERER']); 
                }
            }

            else {
                echo ' <script>alert("Il faut renseigner une date");window.history.back() ;</script>';
            }  
        }
        
        else{
            echo ' <script>alert("Il faut sélectionner une sensibilisation");window.history.back() ;</script>';
        }

    }   


    if ($_POST['newEmploye']) {

        $infoEmploye = explode("__", $_POST['newEmploye']);

        $req = $connect->prepare('Select EMP_ID as idEmploye from employe where EMP_NOM = ? and EMP_PRENOM = ?');
        $req->execute(array($infoEmploye[0], $infoEmploye[1]));

        $idSen = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idEmp = $donnees ['idEmploye'];
        }
        

        if($idEmp==true){

            if (!empty($_POST['date'])) {
            
                foreach($select as $key){
                    if (($key['EMP_ID'] == $idEmp) && ($key['SEN_ID'] == $idSen) && ($key['EMPSEN_DATE'] == $_POST['date'])) {
                        $doublon=true;
                    }
                }

                if($doublon==true){
                    echo ' <script>alert("Cette sensibilisation est déjà attribué à cet employé à cette date");window.history.back() ;</script>';
                }

                else {
                    $data= array(
                        "EMP_ID" => $idEmp,
                        "SEN_ID" => $idSen,
                        "EMPSEN_DATE" => $_POST['date'],
                        );
                    $bdd->INSERT("employesensibilisation",$data);
                    header("location:" . $_SERVER['HTTP_REFERER']); 
                }
            }

            else {
                echo ' <script>alert("Il faut renseigner une date");window.history.back() ;</script>';
            }  
        }
        
        else{
            echo ' <script>alert("Il faut sélectionner un employé");window.history.back() ;</script>';
        }

    }   


    $req->closeCursor();
?> 