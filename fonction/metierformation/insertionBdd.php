<?php 

	include "../../bdd/bdd.php";

    $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');
    $doublon=false;

    if ($_POST['newFormation']) {

        $req = $connect->prepare('Select FOR_ID as idFormation from formation where FOR_NOM = ?');
        $req->execute(array($_POST['newFormation']));

        $idMet = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idFor = $donnees ['idFormation'];
        }
            

        $select=$bdd->SELECTALL("metierformation");

        if($idFor==true){
            
            foreach($select as $key){
                if (($key['MET_ID'] == $idMet) && ($key['FOR_ID'] == $idFor)) {
                    $doublon=true;
                }
            }
            if($doublon==true){
                echo ' <script>alert("Cette formation est déjà attribué à ce métier");window.history.back() ;</script>';
            }

            else {
                $data= array(
                    "MET_ID" => $idMet,
                    "FOR_ID" => $idFor,
                    );
                $bdd->INSERT("metierformation",$data);
                header("location:" . $_SERVER['HTTP_REFERER']);
            }
        }
        
        else {
            echo ' <script>alert("Il faut sélectionner une formation");window.history.back() ;</script>';
        }
    }


    if ($_POST['newMetier']) {

        $req = $connect->prepare('Select MET_ID as idMetier from metier where MET_NOM = ?');
        $req->execute(array($_POST['newMetier']));

        $idFor = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idMet = $donnees ['idMetier'];
        }
            

        $select=$bdd->SELECTALL("metierformation");

        if($idMet==true){
            
            foreach($select as $key){
                if (($key['MET_ID'] == $idMet) && ($key['FOR_ID'] == $idFor)) {
                    $doublon=true;
                }
            }
            if($doublon==true){
                echo ' <script>alert("Ce métier est déjà attribué à cette formation");window.history.back() ;</script>';
            }

            else {
                $data= array(
                    "MET_ID" => $idMet,
                    "FOR_ID" => $idFor,
                    );
                $bdd->INSERT("metierformation",$data);
                header("location:" . $_SERVER['HTTP_REFERER']);
            }
        }
        
        else {
            echo ' <script>alert("Il faut sélectionner un métier");window.history.back() ;</script>';
        }
    }
    

    $req->closeCursor();
?> 