<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ruvalor</title>
    <?php 
        include "../bdd/bdd.php";
        $select=$bdd->SELECTALL("formation");
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

    $_SESSION['FOR_ID'] = $_GET['numId'];

    $req=$connect->prepare('select * from formation where FOR_ID = ?');
    $req->execute(array($_SESSION['FOR_ID']));

    $select=$req->fetch();

    ?>

    <h1 >
        <a href="formation.php">
            Informations sur <?=$select['FOR_NOM']?>
        </a>
    </h1>

    <div class="displayInfo">
        <div class="affichageInfo">
            <div class="divInfo" id="divEmploye"> 
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="employe.php">Employés ayant effectué cette formation&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo"> 
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select EMP_NOM as nom, EMP_PRENOM as prenom, EMPFOR_DATE as date, EMPFOR_DATEFIN as datefin, EMPFOR_ID as id from employe as e, employeFormation as ef where e.EMP_ID = ef.EMP_ID and FOR_ID = ? ORDER BY nom ASC');
                            $req->execute(array($select['FOR_ID'])); 

                            if ($donnees = $req->fetch()) {
                                do {
                                    if (isset($donnees ['nom']) && isset($donnees ['prenom']) && !isset($donnees['date']) && isset($donnees['datefin'])) {

                                                $date_future = $donnees['datefin']; // date future au format "année-mois-jour"
                                                $timestamp_future = strtotime($date_future); // convertit la date future en un timestamp UNIX

                                                $timestamp_actuel = time(); // récupère le timestamp UNIX de la date actuelle

                                                $diff_timestamps = $timestamp_future - $timestamp_actuel; // calcule la différence entre les deux timestamps en secondes

                                                $diff_jours = floor($diff_timestamps / (60 * 60 * 24)); // convertit la différence en jours entiers

                                                if(60 < $diff_jours && $diff_jours < 180){
                                                echo "<div class='elemInfo' id='elemInfoEmpOrange'>";
                                                }
                                                elseif ($diff_jours < 60) {
                                                echo "<div class='elemInfo' id='elemInfoEmpRed'>";
                                                }
                                                else{
                                                echo "<div class='elemInfo' id='elemInfoEmp'>";
                                                }

                                        ?>
                                            <p>
                                                <div class="elemInfo-4-1"><a href="employe.php"> <?php echo $donnees ['nom'];?> </a></div>
                                                <div class="elemInfo-4-2"><a href="employe.php"> <?php echo $donnees ['prenom'];?> </a></div>
                                                <div class="elemInfo-4-3"> - </div>
                                                <div class="elemInfo-4-4"> <?php echo "Expire le ", $donnees['datefin'];?></div>
                                                <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                                <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                    <div id="popup" class="popupSupp">
                                                        <h4> 
                                                            <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['prenom']?> <?=$donnees ['nom']?>" ?</div>
                                                        </h4>
                                                        <p>
                                                            <div class="textPopSupp">
                                                                <span id="btnAnnuler_<?= $donnees['id']?>" class="btnAnnuler">Annuler</span>
                                                                <a class="supp" href="../fonction/employeformation/suppBdd.php?numId=<?= $donnees['id']?>">Supprimer</a>
                                                            </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                        <?php
                                    }
                                    if (isset($donnees ['nom']) && isset($donnees ['prenom']) && isset($donnees['date']) && !isset($donnees['datefin'])) {
                                        ?>
                                        <div class="elemInfo" id="elemInfoEmp">
                                            <p>
                                                <div class="elemInfo-4-1"><a href="employe.php"> <?php echo $donnees ['nom'];?> </a></div>
                                                <div class="elemInfo-4-2"><a href="employe.php"> <?php echo $donnees ['prenom'];?> </a></div>
                                                <div class="elemInfo-4-3"> <?php echo "Effectuée le ",$donnees['date'];?></div>
                                                <div class="elemInfo-4-4"> - </div>
                                                <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                                <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                    <div id="popup" class="popupSupp">
                                                        <h4> 
                                                            <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['prenom']?> <?=$donnees ['nom']?>" ?</div>
                                                        </h4>
                                                        <p>
                                                            <div class="textPopSupp">
                                                                <span id="btnAnnuler_<?= $donnees['id']?>" class="btnAnnuler">Annuler</span>
                                                                <a class="supp" href="../fonction/employeformation/suppBdd.php?numId=<?= $donnees['id']?>">Supprimer</a>
                                                            </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                        <?php
                                    }
                                    if (isset($donnees ['nom']) && isset($donnees ['prenom']) && isset($donnees['date']) && isset($donnees['datefin'])) {

                                                $date_future = $donnees['datefin']; // date future au format "année-mois-jour"
                                                $timestamp_future = strtotime($date_future); // convertit la date future en un timestamp UNIX

                                                $timestamp_actuel = time(); // récupère le timestamp UNIX de la date actuelle

                                                $diff_timestamps = $timestamp_future - $timestamp_actuel; // calcule la différence entre les deux timestamps en secondes

                                                $diff_jours = floor($diff_timestamps / (60 * 60 * 24)); // convertit la différence en jours entiers

                                                if(60 < $diff_jours && $diff_jours < 180){
                                                echo "<div class='elemInfo' id='elemInfoEmpOrange'>";
                                                }
                                                elseif ($diff_jours < 60) {
                                                echo "<div class='elemInfo' id='elemInfoEmpRed'>";
                                                }
                                                else{
                                                echo "<div class='elemInfo' id='elemInfoEmp'>";
                                                }

                                        ?>
                                            <p>
                                                <div class="elemInfo-4-1"><a href="employe.php"> <?php echo $donnees ['nom'];?> </a></div>
                                                <div class="elemInfo-4-2"><a href="employe.php"> <?php echo $donnees ['prenom'];?> </a></div>
                                                <div class="elemInfo-4-3"> <?php echo "Effectuée le ",$donnees['date'];?></div>
                                                <div class="elemInfo-4-4"> <?php echo "Expire le ", $donnees['datefin'];?></div>
                                                <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                                <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                    <div id="popup" class="popupSupp">
                                                        <h4> 
                                                            <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['prenom']?> <?=$donnees ['nom']?>" ?</div>
                                                        </h4>
                                                        <p>
                                                            <div class="textPopSupp">
                                                                <span id="btnAnnuler_<?= $donnees['id']?>" class="btnAnnuler">Annuler</span>
                                                                <a class="supp" href="../fonction/employeformation/suppBdd.php?numId=<?= $donnees['id']?>">Supprimer</a>
                                                            </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                        <?php
                                    }
                                } while ($donnees = $req->fetch());
                            }
                            else {
                                ?>
                                <div class="elemInfo" id="elemInfoEmp">
                                    <p>
                                        <div class="elemInfo-1">Cette formation n'a été effectué par aucun employé.</div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();

                            $req = $connect->prepare('Select EMP_NOM as nom, EMP_PRENOM as prenom from employe ORDER BY nom ASC');
                            $req->execute();
                            ?>
                                                            
                            <form class="formInfo" action="../fonction/employeformation/insertionBdd.php?numId=<?= $_SESSION["FOR_ID"]?>" method="POST">
                                <div class="elemInfo-4-1_2">
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
                                <div class="elemInfo-4-3">
                                    <input class="selectInfo" type="date" id="FOR_DATE" name="date" placeholder="Date"/>
                                </div>
                                <div class="elemInfo-4-4">
                                    <input class="selectInfo" type="date" id="FOR_DATEFIN" name="dateFin" placeholder="Date d'expiration"/>
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
                        <p><a href="metier.php">Métiers pour lesquels la formation est nécessaire&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo">
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select MET_NOM as nom, METFOR_ID as id from metier as m, metierformation as mf where m.MET_ID = mf.MET_ID and FOR_ID = ? ORDER BY nom ASC');
                            $req->execute(array($select['FOR_ID']));

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
                                <div class="elemInfo" id="elemInfoMet">
                                    <p>
                                        <div class="elemInfo-1">Cette formation n'est pas nécessaire à un métier.</div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();

                            $req = $connect->prepare('Select MET_NOM as nomMetier from metier ORDER BY nomMetier ASC');
                            $req->execute();
                            ?>
                                                            
                            <form class="formInfo" action="../fonction/metierformation/insertionBdd.php?numId=<?= $_SESSION["FOR_ID"]?>" method="POST">
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