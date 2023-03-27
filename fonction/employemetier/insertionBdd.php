<?php 

	include "../../bdd/bdd.php";

    $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');
    $doublon=false;

    $select=$bdd->SELECTALL("employemetier");


    if (isset($_POST['newMetier'])) {
        $req = $connect->prepare('Select MET_ID as idMetier from metier where MET_NOM = ?');
        $req->execute(array($_POST['newMetier']));

        $idEmp = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idMet = $donnees ['idMetier'];
        }


        if($idMet==true){
        
            foreach($select as $key){
                if (($key['EMP_ID'] == $idEmp) && ($key['MET_ID'] == $idMet)) {
                    $doublon=true;
                }
            }
            if($doublon==true){
                echo ' <script>alert("Ce métier est déjà attribué à cet employé");window.history.back() ;</script>';
            }

            else {
                $data= array(
                    "EMP_ID" => $idEmp,
                    "MET_ID" => $idMet,
                    );
                $bdd->INSERT("employemetier",$data);
                header("location:" . $_SERVER['HTTP_REFERER']); 
            }
        }
        else{
            echo ' <script>alert("Il faut sélectionner un métier");window.history.back() ;</script>';
        }
    }
    


    if (isset($_POST['newEmploye'])) {


        $infoEmploye = explode("__", $_POST['newEmploye']);

        $req = $connect->prepare('Select EMP_ID as idEmploye from employe where EMP_NOM = ? and EMP_PRENOM = ?');
        $req->execute(array($infoEmploye[0], $infoEmploye[1]));

        echo $infoEmploye[0];

        echo $infoEmploye[1];

        $idMet = $_GET['numId'];

        if ($donnees = $req->fetch()) {
            $idEmp = $donnees ['idEmploye'];
        }

        if($idEmp==true){
        
            foreach($select as $key){
                if (($key['EMP_ID'] == $idEmp) && ($key['MET_ID'] == $idMet)) {
                    $doublon=true;
                }
            }
            if($doublon==true){
                echo ' <script>alert("Ce métier est déjà attribué à cet employé");window.history.back() ;</script>';
            }

            else {
                $data= array(
                    "EMP_ID" => $idEmp,
                    "MET_ID" => $idMet,
                    );
                $bdd->INSERT("employemetier",$data);
                header("location:" . $_SERVER['HTTP_REFERER']); 
            }
        }
        else{
            echo ' <script>alert("Il faut sélectionner un employé");window.history.back() ;</script>';
        }


    }

    $req->closeCursor();
    
        

?> 