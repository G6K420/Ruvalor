<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ruvalor</title>
    <?php 
        include "../bdd/bdd.php";
        $select=$bdd->SELECTALL("employe");
    ?>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/affichageBdd.css">
    <link rel="stylesheet" href="../css/affichageInfo.css">
    <script src="../js/scriptSupp.js" defer></script>
    <script src="../js/scriptModif.js" defer></script>
    <script src="../js/scriptInfo.js" defer></script>

</head>

<body>

    <?php $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); ?>

    <h1><a href="accueil.php">Employé</a></h1>

    <?php
    $req = $connect->prepare('Select count(*) from employe');
    $req->execute();
    $nbr = $req->fetch();
    ?>

    <p class="displayNbr">Nombre d'employé : <?php print_r($nbr[0]) ?></p> 

    <?php
    $req->closeCursor();
    ?>

    <div align="center">
        <form class="form" id="formSearch" method="POST">
            <input class="formInput" type="text" name="search" placeholder="NOM / Prénom / Numéro de sécurité sociale" style="width:70%"/>
            <input type="submit" class="submit" value="Filtrer !" /> 
        </form>
    </div>
    

    <div id="displayBdd">
        <table>
            <tbody>
                

                <?php
                    $sql='select * from employe';
                    $params=[];
                    if(isset($_POST['search'])){
                        $sql.=' where (EMP_NOM like :filter or EMP_PRENOM like :filter or EMP_SECU like :filter)';
                        $params[':filter']="%".addcslashes($_POST['search'],'_')."%";
                    };
                    $sql.=' ORDER BY EMP_NOM ASC';
                    $resultats=$connect->prepare($sql);
                    $resultats->execute($params);
                    if($resultats->rowCount()>0){ 
              
                        while($select=$resultats->fetch(PDO::FETCH_ASSOC)){
                        
                        ?>
                            <div id="displayElement">

                                <div id="element">
                                    
                                    <div class="elem1" ><a href="employeInformation.php?numId=<?= $select["EMP_ID"]?>"><p><?= $select['EMP_NOM'] ?></p></a></div>
                                    <div class="elem2" ><a href="employeInformation.php?numId=<?= $select["EMP_ID"]?>"><p><?= $select['EMP_PRENOM'] ?></p></a></div>
                                    <div class="elem3" ><a href="employeInformation.php?numId=<?= $select["EMP_ID"]?>"><p><?= $select['EMP_SECU'] ?></p></a></div>

                                </div>


                                <div id="btnModifSupp">

                                    <button id="btnModif" class="btnModif" onclick="openModif('<?= $select['EMP_ID'] ?>');">Modification</button>
                                    <div id="overlayModif_<?= $select['EMP_ID'] ?>"  class="overlay">
                                        <div id="popup" class="popupModif">
                                            <p>
                                                <span id="btnCloseX_<?= $select['EMP_ID']?>" class="btnCloseX">X</span>
                                                <div align="center">
                                                <form class="form" action="../fonction/employe/modif.php" method="POST">
                                                        <input type="hidden" name="numId" value="<?=$select['EMP_ID'] ?>"/>
                                                    <p><input class="formInput" style="margin-left: 11px" type="text" name="EMP_NOM" value="<?=$select['EMP_NOM']; ?>"/> </p>
                                                    <p><input class="formInput" type="text" name="EMP_PRENOM" value="<?=$select['EMP_PRENOM']; ?>"/> </p>
                                                    <p><input class="formInput" type="text" name="EMP_SECU" value="<?=$select['EMP_SECU']; ?>"/> </p>
                                                    <div> <input type="submit" class="submit" id="submitModif" value="Enregistrer les modifications !" /> </div>
                                                </form>
                                                </div>
                                            </p>
                                        </div>
                                    </div>

                                    <button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $select['EMP_ID'] ?>');">x</button>
                                    <div id="overlaySupp_<?= $select['EMP_ID'] ?>"  class="overlay">
                                        <div id="popup" class="popupSupp">
                                            <h4> 
                                                <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$select['EMP_NOM']?> <?=$select['EMP_PRENOM']?>" ?</div>
                                            </h4>
                                            <p>
                                                <div class="textPopSupp">
                                                    <span id="btnAnnuler_<?= $select['EMP_ID']?>" class="btnAnnuler">Annuler</span>
                                                    <a class="supp" href="../fonction/employe/suppBdd.php?numId=<?= $select["EMP_ID"]?>">Supprimer</a>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        $resultats->closeCursor();
                    } 
                    else echo "<tr><td colspan=4>Aucun élément correspondant à votre recherche n'a été trouvé.</td></tr>".
                    $connect=null;
                ?>
            </tbody>
        </table>
    </div> 


            <div align="center">
            <form class="form" action="../fonction/employe/insertionBdd.php" method="POST">
                <p><input class="formInput" type="text" id="EMP_NOM" required name="nom" placeholder="NOM"/> </p>
                <p><input class="formInput" type="text" id="EMP_PRENOM" required name="prenom" placeholder="Prénom"/> </p>
                <p><input class="formInput" type="number" id="EMP_SECU" minlength="13" maxlength="15" required name="secu" placeholder="Numéro de sécurité sociale"/> </p>
                <div> <input type="submit" class="submit" value="Ajouter !" /> </div>
            </form>
            </div>

</body>

</html>