<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ruvalor</title>
    <?php 
    /*
        include "../bdd/bdd.php";
        $select=$bdd->SELECTALL("employe");
    */
    ?>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/affichageBdd.css">
    <link rel="stylesheet" href="../css/affichageInfo.css">
    <script src="../js/scriptSupp.js" defer></script>

</head>

<body>
    <?php 
    $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); 

    $_SESSION['EMP_ID'] = $_GET['numId'];

    $req=$connect->prepare('select * from employe where EMP_ID = ?');
    $req->execute(array($_SESSION['EMP_ID']));

    $select=$req->fetch();

    ?>

    <h1 >
        <a href="employe.php">
            Informations sur <?=$select['EMP_PRENOM']?>
        </a>
    </h1>

    <div class="displayInfo">
        <div class="affichageInfo">
            <div class="divEmploye">
                <div class="infoEmploye" id="divEmploye">
                    <div class="elemEmp"> 
                        <?=$select['EMP_NOM']?> 
                    </div> <br/>
                    <div class="elemEmp">
                        <?=$select['EMP_PRENOM']?> 
                    </div> <br/>
                    <div class="elemEmp">
                        <?=$select['EMP_SECU']?> 
                    </div>
                </div>
                                            
                <div class="photoEmploye">

                    <?php
                    $id = $_SESSION['EMP_ID'];
                    $photo = "../img/photo/$id.jpg";    

                    if (realpath($photo)) {
                        ?>
                        <div class="elemInfo-1">
                            <img src = "../img/photo/<?=$_SESSION['EMP_ID']?>.jpg" alt="Photo de l'employé" />
                        </div>
                        <div style="margin-top: 30%;" class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $_SESSION['EMP_ID']?>');">x</button></div>
                        <div id="overlaySupp_<?= $_SESSION['EMP_ID']?>" class="overlay">
                            <div id="popup" class="popupSupp">
                                <h4> 
                                    <div class="titrePopSupp">Êtes-vous sûre de vouloir supprimer la photo de cet employé ?</div>
                                </h4>
                                <p>
                                    <div class="textPopSupp">
                                        <span id="btnAnnuler_<?= $_SESSION['EMP_ID']?>" class="btnAnnuler">Annuler</span>
                                        <a class="supp" href="../fonction/employe/suppImg.php?numId=<?= $_SESSION['EMP_ID']?>">Supprimer</a>
                                    </div>
                                </p>
                            </div>
                        </div>
                    <?php
                    }

                    else {
                        ?>

                        <form class="formFile" action="../fonction/employe/insertionImg.php?numId=<?= $_SESSION['EMP_ID']?>" method="POST" enctype="multipart/form-data">
                            <input class="inputFile" type="file" name="monImage">
                            <input class="submitFile" type="submit" name="envoyer" value="Envoyer">
                        </form>

                    <?php
                    }
                    ?>
                

                </div>
            </div>

                                            
            <div class="divInfo" id="divMetier"> 
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="metier.php">Métiers exercés&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo"> 
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select MET_NOM as metier, EMPMET_ID as id from metier as m, employemetier as em where m.MET_ID = em.MET_ID and EMP_ID = ? ORDER BY metier ASC');
                            $req->execute(array($_SESSION['EMP_ID']));

                            if ($donnees = $req->fetch()) {
                                do {
                                    ?>
                                    <div class="elemInfo" id="elemInfoMet">
                                        <p>
                                            <div class="elemInfo-1"><a href="metier.php"><?php echo $donnees ['metier']; ?></a></div>
                                            <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                            <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                <div id="popup" class="popupSupp">
                                                    <h4> 
                                                        <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['metier']?>" ?</div>
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
                                <div class="elemInfo" id="elemInfoMet">
                                    <p>
                                        <div class="elemInfo-1"> Cet employé n'a pas encore de métier. </div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();


                            $req = $connect->prepare('Select MET_NOM as nomMetier from metier ORDER BY nomMetier ASC');
                            $req->execute();
                            ?>
                            <form style="margin-top: 10px;" class="forminfo" action="../fonction/employemetier/insertionBdd.php?numId=<?= $_SESSION["EMP_ID"]?>" method="POST">
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

                                            
            <div class="divInfo" id="divFormation">
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="formation.php">Formations suivies&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo">
                        <div class="elementInfo">
                            <?php
                            $req = $connect->prepare('Select FOR_NOM as nom, EMPFOR_DATE as date, EMPFOR_DATEFIN as datefin, EMPFOR_ID as id from 
                                formation as f, employeFormation as ef where f.FOR_ID = ef.FOR_ID and EMP_ID = ? ORDER BY nom ASC');
                            $req->execute(array($_SESSION['EMP_ID'])); 

                            if ($donnees = $req->fetch()) {
                                do {
                                    if (isset($donnees ['nom']) && !isset($donnees['date']) && isset($donnees['datefin'])) {

                                                $date_future = $donnees['datefin']; // date future au format "année-mois-jour"
                                                $timestamp_future = strtotime($date_future); // convertit la date future en un timestamp UNIX

                                                $timestamp_actuel = time(); // récupère le timestamp UNIX de la date actuelle

                                                $diff_timestamps = $timestamp_future - $timestamp_actuel; // calcule la différence entre les deux timestamps en secondes

                                                $diff_jours = floor($diff_timestamps / (60 * 60 * 24)); // convertit la différence en jours entiers

                                                if(60 < $diff_jours && $diff_jours < 180){
                                                echo "<div class='elemInfo' id='elemInfoForOrange'>";
                                                }
                                                elseif ($diff_jours < 60) {
                                                echo "<div class='elemInfo' id='elemInfoForRed'>";
                                                }
                                               else{
                                                echo "<div class='elemInfo' id='elemInfoFor'>";
                                               }
                                    
                                        ?>
                                            <p>
                                                <div class="elemInfo-3-1"><a href="formation.php"> <?php echo $donnees ['nom'];?> </a></div> 
                                                <div class="elemInfo-3-2"> - </div>
                                                <div class='elemInfo-3-3 '> <?php echo "Expire le ", $donnees['datefin'];?></div>

                                                <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                                <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                    <div id="popup" class="popupSupp">
                                                        <h4> 
                                                            <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['nom']?>" ?</div>
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
                                    if (isset($donnees ['nom']) && isset($donnees['date']) && !isset($donnees['datefin'])) {
                                        ?>
                                        <div class="elemInfo" id="elemInfoFor">
                                            <p>
                                                <div class="elemInfo-3-1"><a href="formation.php"> <?php echo $donnees ['nom'];?> </a></div>
                                                <div class="elemInfo-3-2"> <?php echo "Effectuée le ",$donnees['date'];?></div>
                                                <div class="elemInfo-3-3"> - </div>
                                                <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                                <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                    <div id="popup" class="popupSupp">
                                                        <h4> 
                                                            <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['nom']?>" ?</div>
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
                                    if (isset($donnees ['nom']) && isset($donnees['date']) && isset($donnees['datefin'])) {

                                                $date_future = $donnees['datefin']; // date future au format "année-mois-jour"
                                                $timestamp_future = strtotime($date_future); // convertit la date future en un timestamp UNIX

                                                $timestamp_actuel = time(); // récupère le timestamp UNIX de la date actuelle

                                                $diff_timestamps = $timestamp_future - $timestamp_actuel; // calcule la différence entre les deux timestamps en secondes

                                                $diff_jours = floor($diff_timestamps / (60 * 60 * 24)); // convertit la différence en jours entiers

                                                if(60 < $diff_jours && $diff_jours < 180){
                                                echo "<div class='elemInfo' id='elemInfoForOrange'>";
                                                }
                                                elseif ($diff_jours < 60) {
                                                echo "<div class='elemInfo' id='elemInfoForRed'>";
                                                }
                                               else{
                                                echo "<div class='elemInfo' id='elemInfoFor'>";
                                               }

                                        ?>
                                            <p>
                                                <div class="elemInfo-3-1"><a href="formation.php"> <?php echo $donnees ['nom'];?> </a></div>
                                                <div class="elemInfo-3-2"> <?php echo "Effectuée le ",$donnees['date'];?></div>
                                                <div class="elemInfo-3-3"> <?php echo "Expire le ", $donnees['datefin'];?></div>
                                                <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                                <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                                    <div id="popup" class="popupSupp">
                                                        <h4> 
                                                            <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['nom']?>" ?</div>
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
                                <div class="elemInfo" id="elemInfoFor">
                                    <p>
                                        <div class="elemInfo-1"> Cet employé n'a pas effectué de formation. </div>
                                    </p>
                                </div>
                                <?php
                            }
                            $req->closeCursor();

                            $req = $connect->prepare('Select FOR_NOM as nomFormation from formation ORDER BY nomFormation ASC');
                            $req->execute();
                            ?>
                                                            
                            <form class="formInfo" action="../fonction/employeformation/insertionBdd.php?numId=<?= $_SESSION["EMP_ID"]?>" method="POST">
                                <div class="elemInfo-3-1">
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
                                <div class="elemInfo-3-2">
                                    <input class="selectInfo" type="date" id="FOR_DATE" name="date" placeholder="Date"/>
                                </div>
                                <div class="elemInfo-3-3">
                                    <input class="selectInfo" type="date" id="FOR_DATEFIN" name="dateFin" placeholder="Date d'expiration"/>
                                </div>
                                <div class="elemInfo-1">
                                    <input class="submitInfo" id="elemInfoFor" type="submit" value="Ajouter !" /> 
                                </div>
                            </form>
                                                            
                            <?php
                            $req->closeCursor();
                            ?>
                        </div>
                    </div>
                </div>
            </div>

                                            
            <div class="divInfo" id="divSensibilisation">
                <div class="divdivInfo">
                    <div class="titreInfo">
                        <p><a href="sensibilisation.php">Sensibilisations reçues&nbsp;:</a></p>
                    </div>
                    <div class="nomInfo">
                        <div class="elementInfo">
                        <?php
                        $req = $connect->prepare('Select SEN_NOM as nom, EMPSEN_DATE as date, EMPSEN_ID as id from sensibilisation as s, employeSensibilisation as es where s.SEN_ID = es.SEN_ID and EMP_ID = ? ORDER BY nom ASC');
                        $req->execute(array($_SESSION['EMP_ID'])); 

                        if ($donnees = $req->fetch()) {
                            do {
                                ?>
                                <div class="elemInfo" id="elemInfoSen">
                                    <p>
                                        <div class="elemInfo-2-1"><a href="sensibilisation.php"> <?php echo $donnees ['nom'];?> </a></div>
                                        <div class="elemInfo-2-2"> <?php echo "Effectuée le ",$donnees['date'];?></div>
                                        <div class="elemInfoBtn"><button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $donnees['id']?>');">x</button></div>
                                        <div id="overlaySupp_<?= $donnees['id']?>"  class="overlay">
                                            <div id="popup" class="popupSupp">
                                                <h4> 
                                                    <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$donnees ['nom']?>" ?</div>
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
                            <div class="elemInfo" id="elemInfoSen">
                                <p>
                                    <div class="elemInfo-1"> Cet employé n'a pas effectué de sensibilisation. </div>
                                </p>
                            </div>
                            <?php
                        }
                        $req->closeCursor();

                        $req = $connect->prepare('Select SEN_NOM as nomSensibilisation from sensibilisation ORDER BY nomSensibilisation ASC');
                        $req->execute();
                        ?>
                                                            
                        <form class="formInfo" action="../fonction/employesensibilisation/insertionBdd.php?numId=<?= $_SESSION["EMP_ID"]?>" method="POST">
                            <div class="elemInfo-2-1">
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
                            <div class="elemInfo-2-2">
                                <input class="selectInfo" type="date" id="SEN_DATE" name="date" placeholder="Date"/>
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

    <a href="../fonction/PDF.php?numId=<?= $_SESSION['EMP_ID']?>"> Exporter en PDF </a>

    <?php $req->closeCursor(); ?>                            

</body>

</html>