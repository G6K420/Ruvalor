<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ruvalor</title>
    <?php 
        include "../bdd/bdd.php";
        $select=$bdd->SELECTALL("sensibilisation");
    ?>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/affichageBdd.css">
    <link rel="stylesheet" href="../css/affichageInfo.css">
    <script src="../js/scriptSupp.js" defer></script>
    <script src="../js/scriptModif.js" defer></script>
    <script src="../js/scriptInfo.js" defer></script>
</head>

<body>
    <?php 
    $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); 

    $_SESSION['SEN_ID'] = $_GET['numId'];

    $req=$connect->prepare('select * from sensibilisation where SEN_ID = ?');
    $req->execute(array($_SESSION['SEN_ID']));

    $select=$req->fetch();

    ?>

    <h1 >
        <a href="sensibilisation.php">
            Informations sur <?=$select['SEN_NOM']?>
        </a>
    </h1>

    <div class="displayInfo">
        <div class="affichageInfo">
    
            <div class="divInfo" id="divEmploye"> 
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="employe.php">Employés qui ont effectué cette sensibilisation&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo"> 
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select EMP_NOM as nom, EMP_PRENOM as prenom, EMPSEN_DATE as date, EMPSEN_ID as id from employe as e, employeSensibilisation as es where e.EMP_ID = es.EMP_ID and SEN_ID = ? ORDER BY nom ASC');
                            $req->execute(array($select['SEN_ID'])); 

                            if ($donnees = $req->fetch()) {
                                do {
                                    ?>
                                    <div class="elemInfo" id="elemInfoEmp">
                                        <p>
                                            <div class="elemInfo-3-1"><a href="employe.php"> <?php echo $donnees ['nom'];?> </a></div>
                                            <div class="elemInfo-3-2"><a href="employe.php"> <?php echo $donnees ['prenom'];?> </a></div>
                                            <div class="elemInfo-3-3"> <?php echo "Effectuée le ",$donnees['date'];?></div>
                                            <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                            <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                <div id="popup" class="popupSupp">
                                                    <h4> 
                                                        <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['prenom']?> <?=$donnees ['nom']?>" ?</div>
                                                    </h4>
                                                    <p>
                                                        <div class="textPopSupp">
                                                            <span id="btnAnnuler_<?= $donnees['id']?>" class="btnAnnuler">Annuler</span>
                                                            <a class="supp" href="../fonction/employesensibilisation/suppBdd.php?numId=<?= $donnees['id']?>">Supprimer</a>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                    <?php
                                } while ($donnees = $req->fetch()) ;
                            } 
                            else {
                                ?>
                                <div class="elemInfo" id="elemInfoEmp">
                                    <p>
                                        <div class="elemInfo-1">Cette sensibilisation n'a été effectué par aucun emmployé.</div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();
                            

                            $req = $connect->prepare('Select EMP_NOM as nom, EMP_PRENOM as prenom from employe ORDER BY nom ASC');
                            $req->execute();
                            ?>
                                                            
                            <form class="formInfo" action="../fonction/employesensibilisation/insertionBdd.php?numId=<?= $_SESSION["SEN_ID"]?>" method="POST">
                                <div class="elemInfo-3-1_2">
                                    <select name="newEmploye" class="selectInfo">
                                        <option selected="selected">Ajouter un employé</option>
                                        <?php
                                        while ($donnees = $req->fetch()) { ?>
                                            <option><?php echo $donnees ['nom'], "__", $donnees['prenom']; ?></option>
                                            <?php
                                        } 
                                        ?>
                                    </select>
                                </div>
                                <div class="elemInfo-3-3">
                                    <input class="selectInfo" type="date" id="SEN_DATE" name="date" placeholder="Date"/>
                                </div>
                                <div class="elemInfo-1">
                                    <input class="submitInfo" id="elemInfoEmp" type="submit" value="Ajouter !" /> 
                                </div>
                            </form>
                                                            
                            <?php
                            $req->closeCursor();
                            ?>
                        </div>
                    </div>
                </div>
            </div>  

            <div class="divInfo" id="divMetier">
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="metier.php">Métiers pour lesquels la sensibilisation est nécessaire&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo">
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select MET_NOM as nom, METSEN_ID as id from metier as m, metiersensibilisation as ms where m.MET_ID = ms.MET_ID and SEN_ID = ? ORDER BY nom ASC');
                            $req->execute(array($select['SEN_ID']));

                            if ($donnees = $req->fetch()) {
                                do {
                                    ?>
                                    <div class="elemInfo" id="elemInfoMet">
                                        <p>
                                            <div class="elemInfo-1"><a href="metier.php"><?php echo $donnees ['nom']; ?></a></div>
                                            <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                            <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                <div id="popup" class="popupSupp">
                                                    <h4> 
                                                        <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['nom']?>" ?</div>
                                                    </h4>
                                                    <p>
                                                        <div class="textPopSupp">
                                                            <span id="btnAnnuler_<?= $donnees['id']?>" class="btnAnnuler">Annuler</span>
                                                            <a class="supp" href="../fonction/metiersensibilisation/suppBdd.php?numId=<?= $donnees['id']?>">Supprimer</a>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                    <?php
                                } while ($donnees = $req->fetch());
                            }
                            else {
                                ?>
                                <div class="elemInfo" id="elemInfoMet">
                                    <p>
                                        <div class="elemInfo-1">Cette sensibilisation n'est pas nécessaire à un métier.</div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();
                            
                            $req = $connect->prepare('Select MET_NOM as nomMetier from metier ORDER BY nomMetier ASC');
                            $req->execute();
                            ?>
                                                            
                            <form class="formInfo" action="../fonction/metiersensibilisation/insertionBdd.php?numId=<?= $_SESSION["SEN_ID"]?>" method="POST">
                                <div class="elemInfo-1">
                                    <select name="newMetier" class="selectInfo">
                                            <option selected="selected">Ajouter un métier</option>
                                            <?php
                                            while ($donnees = $req->fetch()) { ?>
                                                <option><?php echo $donnees ['nomMetier']; ?></option>
                                                <?php
                                            } 
                                            ?>
                                    </select>
                                </div>
                                <div class="elemInfo-1">
                                    <input class="submitInfo" id="elemInfoMet" type="submit" value="Ajouter !" /> 
                                </div>
                            </form>
                                                                
                            <?php
                            $req->closeCursor();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $resultats->closeCursor();
    ?>

</body>

</html>