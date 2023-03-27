<!DOCTYPE html>
<html>
<body>
   

<?php


include '../bdd/bdd.php';

session_start();

  	$doublonMail=false;
    $doublonLog=false;
    $pasEmploye=false;
    $select=$bdd->SELECTALL("utilisateur");
/*
    $postNom = $_POST['nom'];
    $nom = str_replace(' ', '', $postNom);

    $postPrenom = $_POST['prenom'];
    $prenom = str_replace(' ', '', $postPrenom);
*/
    $postSecu = $_POST['secu'];
    $secu = str_replace(' ', '', $postSecu);

    $postMail = $_POST['mail'];
    $mail = str_replace(' ', '', $postMail);


    
    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($secu) && isset($mail) && isset($_POST['login']) && isset($_POST['mdp']) && isset($_POST['confirmMdp'])){

    $pdo = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root','');

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $req1 = $pdo->prepare("SELECT * FROM employe WHERE EMP_NOM = ?");
    $req1->execute([$nom]); 
    $req2 = $pdo->prepare("SELECT * FROM employe WHERE EMP_PRENOM = ?");
    $req2->execute([$prenom]); 
    $req3 = $pdo->prepare("SELECT * FROM employe WHERE EMP_SECU = ?");
    $req3->execute([$secu]); 
    $verifNom = $req1->fetch();
    $verifPrenom = $req2->fetch();
    $verifSecu = $req3->fetch();
    if ($verifNom && $verifPrenom && $verifSecu) {

        if (filter_var($mail, FILTER_VALIDATE_EMAIL)){
            if($_POST['mdp'] == $_POST['confirmMdp']){
                        
                foreach($select as $key){
                    if($key['UTIL_LOGIN'] == $_POST['login']){
                        $doublonLog=true;
                    }
                    if($key['UTIL_MAIL'] == $mail){
                        $doublonMail=true;
                    }
                }
                        
                if($doublonLog==true){
                    echo ' <script>alert("Login déjà utilisé");window.history.back() ;</script>';
                    return 0;
                }
                if($doublonMail==true){
                    echo ' <script>alert("Email déjà utilisé");window.history.back() ;</script>';
                    return 0;
                }
                        
                else {
                    $password = $_POST['mdp'];
                    $hash = md5($password);

                    $data = array(
                    "UTIL_NOM" => $_POST['nom'],
                    "UTIL_PRENOM" => $_POST['prenom'],
                    "UTIL_SECU" => $secu,
                    "UTIL_MAIL" => $mail,
                    "UTIL_LOGIN" => $_POST['login'],
                    "UTIL_MDP" => $hash
                    );
                    $bdd->INSERT("utilisateur", $data);
                    $_SESSION['session'] = $key['UTIL_LOGIN'];
                    header('Location:../pages/inscripValide.php'); 
                }
            }
            else{
                echo ' <script>alert("Les mots de passes ne sont pas identiques");window.history.back() ;</script>';
            }
        }
        else{
            echo ' <script>alert("Le mail est invalide");window.history.back() ;</script>';
        }  
    } 
    else {
        echo ' <script>alert("Il faut travailler à Ruvalor pour pouvoir s incrire");window.history.back() ;</script>';
    } 

        
                    
    }

?>

</body>
</html>
