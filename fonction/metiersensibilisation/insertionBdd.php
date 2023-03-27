<?php 

	include "../../bdd/bdd.php";

    $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');
    $doublon=false;

    if ($_POST['newSensibilisation']) {
        $req = $connect->prepare('Select SEN_ID as idSensibilisation from sensibilisation where SEN_NOM = ?');
        $req->execute(array($_POST['newSensibilisation']));

        $idMet = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idSen = $donnees ['idSensibilisation'];
        }
            

        $select=$bdd->SELECTALL("metiersensibilisation");

        if($idSen==true){
            
            foreach($select as $key){
                if (($key['MET_ID'] == $idMet) && ($key['SEN_ID'] == $idSen)) {
                    $doublon=true;
                }
            }
            if($doublon==true){
                echo ' <script>alert("Cette sensibilisation est déjà attribué à ce métier");window.history.back() ;</script>';
            }

            else {
                $data= array(
                    "MET_ID" => $idMet,
                    "SEN_ID" => $idSen,
                    );
                $bdd->INSERT("metiersensibilisation",$data);
                header("location:" . $_SERVER['HTTP_REFERER']); 
            }
        }
        
        else {
            echo ' <script>alert("Il faut sélectionner une sensibilisation");window.history.back() ;</script>';
        }
    }

    if ($_POST['newMetier']) {
        $req = $connect->prepare('Select MET_ID as idMetier from metier where MET_NOM = ?');
        $req->execute(array($_POST['newMetier']));

        $idSen = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idMet = $donnees ['idMetier'];
        }
            

        $select=$bdd->SELECTALL("metiersensibilisation");

        if($idMet==true){
            
            foreach($select as $key){
                if (($key['MET_ID'] == $idMet) && ($key['SEN_ID'] == $idSen)) {
                    $doublon=true;
                }
            }
            if($doublon==true){
                echo ' <script>alert("Ce métier est déjà attribué à cette sensibilisation");window.history.back() ;</script>';
            }

            else {
                $data= array(
                    "MET_ID" => $idMet,
                    "SEN_ID" => $idSen,
                    );
                $bdd->INSERT("metiersensibilisation",$data);
                header("location:" . $_SERVER['HTTP_REFERER']); 
            }
        }
        
        else {
            echo ' <script>alert("Il faut sélectionner un métier");window.history.back() ;</script>';
        }
    }
    

    $req->closeCursor();
?> 