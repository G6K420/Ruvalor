<?php

	include '../bdd/bdd.php';
 
$select=$bdd->SELECTALL("utilisateur");
$password = $_POST['mdp'];
$hash = md5($password);
$mauvaisLog=false;
$mauvaisPasse=false;
    
foreach($select as $key){
    if($key['UTIL_LOGIN'] == $_POST['login']){
        if($key['UTIL_MDP'] == $hash){ //password_hash($_POST['mdp'], PASSWORD_BCRYPT)
        	session_start();
            $_SESSION['session'] = $key['UTIL_LOGIN'];
            header('Location:../pages/accueil.php');
        }
        else{
            $mauvaisPasse=true;
        }
    }
    else{
        $mauvaisLog=true;
    }
}
if($mauvaisPasse==true){
    echo ' <script>alert("Mot de passe invalide");window.history.back() ;</script>';
}
else if($mauvaisLog==true){
    echo '<script> alert("Login invalide"); window.history.back();</script>';
}

?>