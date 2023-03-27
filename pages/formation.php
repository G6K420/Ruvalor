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

    <?php $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); ?>

    <h1 ><a href="accueil.php">Formation</a></h1>

    <?php
    $req = $connect->prepare('Select count(*) from formation');
    $req->execute();
    $nbr = $req->fetch();
    ?>

    <p class="displayNbr">Nombre de formation : <?php print_r($nbr[0]) ?></p> 

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
                    $sql='select * from formation';
                    $params=[];
                    if(isset($_POST['search'])){
                        $sql.=' where (FOR_NOM like :filter)';
                        $params[':filter']="%".addcslashes($_POST['search'],'_')."%";
                    };
                    $sql.=' ORDER BY FOR_NOM ASC';
                    $resultats=$connect->prepare($sql);
                    $resultats->execute($params);
                    if($resultats->rowCount()>0){ 
              
                        while($select=$resultats->fetch(PDO::FETCH_ASSOC)){?>
                            <div id="displayElement">
                                <div id="element">
                                    <div class="elemUnique">
                                        <a href="formationInformation.php?numId=<?= $select["FOR_ID"]?>"><p><?= $select['FOR_NOM'] ?></p></a>
                                    </div>
                                </div>


                                <div id="btnModifSupp">
                                    <button id="btnModif" class="btnModif" onclick="openModif('<?= $select['FOR_ID'] ?>');">Modification</button>
                                    <div id="overlayModif_<?= $select['FOR_ID'] ?>"  class="overlay">
                                        <div id="popup" class="popupModif">
                                            <p>
                                                <span id="btnCloseX_<?= $select['FOR_ID']?>" class="btnCloseX">X</span>
                                                <div align="center">
                                                <form class="form" action="../fonction/formation/modif.php" method="POST">
                                                        <input type="hidden" name="numId" value="<?=$select['FOR_ID'] ?>"/>
                                                    <p><input class="formInput" type="text" name="FOR_NOM" value="<?=$select['FOR_NOM']; ?>"/> </p>
                                                    <div> <input type="submit" class="submit" id="submitModif" value="Enregistrer les modifications !" /> </div>
                                                </form>
                                                </div>
                                            </p>
                                        </div>
                                    </div>

                                    <button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $select['FOR_ID'] ?>');">x</button>
                                    <div id="overlaySupp_<?= $select['FOR_ID'] ?>"  class="overlay">
                                        <div id="popup" class="popupSupp">
                                            <h4> 
                                                <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$select['FOR_NOM']?>" ?</div>
                                            </h4>
                                            <div class="textPopSupp">
                                                <span id="btnAnnuler_<?= $select['FOR_ID']?>" class="btnAnnuler">Annuler</span>
                                                <a class="supp" href="../fonction/formation/suppBdd.php?numId=<?= $select["FOR_ID"]?>">Supprimer</a>
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
            <form class="form" action="../fonction/formation/insertionBdd.php" method="POST">
                <p><input class="formInput" type="text" id="FOR_NOM" required name="nom" placeholder="NOM"/> </p>
                <div> <input type="submit" class="submit" value="Ajouter !" /> </div>
            </form>
            </div>

</body>

</html>