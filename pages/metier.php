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

    <?php $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); ?>

    <h1 ><a href="accueil.php">Métier</a></h1>

    <?php
    $req = $connect->prepare('Select count(*) from metier');
    $req->execute();
    $nbr = $req->fetch();
    ?>

    <p class="displayNbr">Nombre de métier : <?php print_r($nbr[0]) ?></p> 

    <?php
    $req->closeCursor();
    ?>

    <div align="center">
        <form class="form" id="formSearch" method="POST">
            <input class="formInput" type="text" name="search" placeholder="Nom du métier" style="width:70%"/> </td>
            <input type="submit" class="submit" value="Filtrer !" /> 
        </form>
    </div>

    <div id="displayBdd">
        <table>
            <tbody>

                <?php
                    $sql='select * from metier';
                    $params=[];
                    if(isset($_POST['search'])){
                        $sql.=' where (MET_NOM like :filter)';
                        $params[':filter']="%".addcslashes($_POST['search'],'_')."%";
                    };
                    $sql.=' ORDER BY MET_NOM ASC';
                    $resultats=$connect->prepare($sql);
                    $resultats->execute($params);
                    if($resultats->rowCount()>0){ 
              
                        while($select=$resultats->fetch(PDO::FETCH_ASSOC)){?>
                            <div id="displayElement">
                                <div id="element">
                                    <div class="elemUnique">
                                        <a href="metierInformation.php?numId=<?= $select["MET_ID"]?>"><p><?= $select['MET_NOM'] ?></p></a>
                                    </div>
                                </div>
                                

                                <div id="btnModifSupp">
                                    <button id="btnModif" class="btnModif" onclick="openModif('<?= $select['MET_ID'] ?>');">Modification</button>
                                    <div id="overlayModif_<?= $select['MET_ID'] ?>"  class="overlay">
                                        <div id="popup" class="popupModif">
                                            <p>
                                                <span id="btnCloseX_<?= $select['MET_ID']?>" class="btnCloseX">X</span>
                                                <div align="center">
                                                <form class="form" id="formModif" action="../fonction/metier/modif.php" method="POST">
                                                        <input type="hidden" name="numId" value="<?=$select['MET_ID'] ?>"/>
                                                    <p><input class="formInput" type="text" name="MET_NOM" value="<?=$select['MET_NOM']; ?>"/> </p>
                                                    <div> <input type="submit" class="submit" id="submitModif" value="Enregistrer les modifications !" /> </div>
                                                </form>
                                                </div>
                                            </p>
                                        </div>
                                    </div>

                                    <button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $select['MET_ID'] ?>');">x</button>
                                    <div id="overlaySupp_<?= $select['MET_ID'] ?>"  class="overlay">
                                        <div id="popup" class="popupSupp">
                                            <h4> 
                                                <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$select['MET_NOM']?>" ?</div>
                                            </h4>
                                            <div class="textPopSupp">
                                                <span id="btnAnnuler_<?= $select['MET_ID']?>" class="btnAnnuler">Annuler</span>
                                                <a class="supp" href="../fonction/metier/suppBdd.php?numId=<?= $select["MET_ID"]?>">Supprimer</a>
                                            </div>
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
            <form class="form" action="../fonction/metier/insertionBdd.php" method="POST">
                <p><input class="formInput" type="text" id="MET_NOM" required name="nom" placeholder="Nom du métier"/> </p>
                <div> <input type="submit" class="submit" value="Ajouter !" /> </div>
            </form>
            </div>

</body>

</html>