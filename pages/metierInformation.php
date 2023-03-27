<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ruvalor</title>
    <?php 
        include "../bdd/bdd.php";
        $select=$bdd->SELECTALL("metier");
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

    $_SESSION['MET_ID'] = $_GET['numId'];

    $req=$connect->prepare('select * from metier where MET_ID = ?');
    $req->execute(array($_SESSION['MET_ID']));

    $select=$req->fetch();

    ?>

    <h1 >
        <a href="metier.php">
            Informations sur <?=$select['MET_NOM']?>
        </a>
    </h1>

    <div class="displayInfo">
        <div class="affichageInfo">
                                            
            <div class="divInfo" id="divEmploye"> 
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="employe.php">Employés qui exercent ce métier&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo"> 
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select EMP_NOM as nom, EMP_PRENOM as prenom, EMPMET_ID as id from employe as e, employemetier as em where e.EMP_ID = em.EMP_ID and MET_ID = ? ORDER BY nom ASC');
                            $req->execute(array($select['MET_ID']));

                            if ($donnees = $req->fetch()) {
                                do {
                                    ?>
                                    <div class="elemInfo"  id="elemInfoEmp">
                                        <p>
                                            <div class="elemInfo-2-1"><a href="employe.php"><?php echo $donnees ['nom']; ?></a></div>
                                            <div class="elemInfo-2-2"><a href="employe.php"><?php echo $donnees ['prenom']; ?></a></div>
                                            <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                            <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                <div id="popup" class="popupSupp">
                                                    <h4> 
                                                        <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['prenom']?> <?=$donnees ['nom']?>" ?</div>
                                                    </h4>
                                                    <p>
                                                        <div class="textPopSupp">
                                                            <span id="btnAnnuler_<?= $donnees['id']?>" class="btnAnnuler">Annuler</span>
                                                            <a class="supp" href="../fonction/employemetier/suppBdd.php?numId=<?= $donnees['id']?>">Supprimer</a>
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
                                <div class="elemInfo" id="elemInfoEmp">
                                    <p>
                                        <div class="elemInfo-1">Ce métier n'a pas encore d'employé.</div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();

                            $req = $connect->prepare('Select EMP_NOM as nom, EMP_PRENOM as prenom from employe ORDER BY nom ASC');
                            $req->execute();
                            ?>
                            <form class="forminfo" action="../fonction/employemetier/insertionBdd.php?numId=<?= $_SESSION["MET_ID"]?>" method="POST">
                                <div class="elemInfo-1">
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

                                            
            <div class="divInfo" id="divFormation">
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="formation.php">Formations nécessaires&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo">
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select FOR_NOM as nom, METFOR_ID as id from formation as f, metierformation as mf where f.FOR_ID = mf.FOR_ID and MET_ID = ? ORDER BY nom ASC');
                            $req->execute(array($select['MET_ID']));

                            if ($donnees = $req->fetch()) {
                                do {
                                    ?>
                                    <div class="elemInfo" id="elemInfoFor">
                                        <p>
                                            <div class="elemInfo-1"><a href="formation.php"><?php echo $donnees ['nom']; ?></a></div>
                                            <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                            <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                <div id="popup" class="popupSupp">
                                                    <h4> 
                                                        <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['nom']?>" ?</div>
                                                    </h4>
                                                    <p>
                                                        <div class="textPopSupp">
                                                            <span id="btnAnnuler_<?= $donnees['id']?>" class="btnAnnuler">Annuler</span>
                                                            <a class="supp" href="../fonction/metierformation/suppBdd.php?numId=<?= $donnees['id']?>">Supprimer</a>
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
                                <div class="elemInfo" id="elemInfoFor">
                                    <p>
                                        <div class="elemInfo-1">Ce métier ne nécessite pas de formation.</div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();
                            
                            $req = $connect->prepare('Select FOR_NOM as nomFormation from formation ORDER BY nomFormation ASC');
                            $req->execute();
                            ?>
                                                            
                            <form class="formInfo" action="../fonction/metierformation/insertionBdd.php?numId=<?= $_SESSION["MET_ID"]?>" method="POST">
                                <div class="elemInfo-1">
                                    <select name="newFormation" class="selectInfo">
                                        <option selected="selected">Ajouter une formation</option>
                                        <?php
                                        while ($donnees = $req->fetch()) { ?>
                                            <option><?php echo $donnees ['nomFormation']; ?></option>
                                            <?php
                                        } 
                                        ?>
                                    </select>
                                </div>
                                <div class="elemInfo-1">
                                    <input class="submitInfo" id="elemInfoFor" type="submit" value="Ajouter !" /> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                                            
            <div class="divInfo" id="divSensibilisation">
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="sensibilisation.php">Sensibilisations recommandées&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo">
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select SEN_NOM as nom, METSEN_ID as id from sensibilisation as s, metiersensibilisation as ms where s.SEN_ID = ms.SEN_ID and MET_ID = ? ORDER BY nom ASC');
                            $req->execute(array($select['MET_ID']));

                            if ($donnees = $req->fetch()) {
                                do {
                                    ?>
                                    <div class="elemInfo" id="elemInfoSen">
                                        <p>
                                            <div class="elemInfo-1"><a href="sensibilisation.php"><?php echo $donnees ['nom']; ?></a></div>
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
                                <div class="elemInfo" id="elemInfoSen">
                                    <p>
                                        <div class="elemInfo-1">Pas de sensibilisation recommandé pour ce métier.</div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();

                            $req = $connect->prepare('Select SEN_NOM as nomSensibilisation from sensibilisation ORDER BY nomSensibilisation ASC');
                            $req->execute();
                            ?>
                                                            
                            <form class="formInfo" action="../fonction/metiersensibilisation/insertionBdd.php?numId=<?= $_SESSION["MET_ID"]?>" method="POST">
                                <div class="elemInfo-1">
                                    <select name="newSensibilisation" class="selectInfo">
                                            <option selected="selected">Ajouter une sensibilisation</option>
                                            <?php
                                            while ($donnees = $req->fetch()) { ?>
                                                <option><?php echo $donnees ['nomSensibilisation']; ?></option>
                                                <?php
                                            } 
                                            ?>
                                    </select>
                                </div>
                                <div class="elemInfo-1">
                                    <input class="submitInfo" id="elemInfoSen" type="submit" value="Ajouter !" /> 
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
    $req->closeCursor();
    ?>


</body>

</html>