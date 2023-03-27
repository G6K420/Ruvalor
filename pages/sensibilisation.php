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

    <?php $connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); ?>

    <h1 ><a href="accueil.php">Sensibilisation</a></h1>

    <?php
    $req = $connect->prepare('Select count(*) from sensibilisation');
    $req->execute();
    $nbr = $req->fetch();
    ?>

    <p class="displayNbr">Nombre de sensibilisation : <?php print_r($nbr[0]) ?></p> 

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
                    $sql='select * from sensibilisation';
                    $params=[];
                    if(isset($_POST['search'])){
                        $sql.=' where (SEN_NOM like :filter)';
                        $params[':filter']="%".addcslashes($_POST['search'],'_')."%";
                    };
                    $sql.=' ORDER BY SEN_NOM ASC';
                    $resultats=$connect->prepare($sql);
                    $resultats->execute($params);
                    if($resultats->rowCount()>0){ 
              
                        while($select=$resultats->fetch(PDO::FETCH_ASSOC)){?>
                            <div id="displayElement">
                                <div id="element">
                                    <div class="elemUnique">
                                        <a href="sensibilisationInformation.php?numId=<?= $select["SEN_ID"]?>"><p><?= $select['SEN_NOM'] ?></p></a>
                                    </div>
                                </div>

                                
                                <div id="btnModifSupp">
                                    <button id="btnModif" class="btnModif" onclick="openModif('<?= $select['SEN_ID'] ?>');">Modification</button>
                                    <div id="overlayModif_<?= $select['SEN_ID'] ?>"  class="overlay">
                                        <div id="popup" class="popupModif">
                                            <p>
                                                <span id="btnCloseX_<?= $select['SEN_ID']?>" class="btnCloseX">X</span>
                                                <div align="center">
                                                <form class="form" action="../fonction/sensibilisation/modif.php" method="POST">
                                                        <input type="hidden" name="numId" value="<?=$select['SEN_ID'] ?>"/>
                                                    <p><input class="formInput" type="text" name="SEN_NOM" value="<?=$select['SEN_NOM']; ?>"/> </p>
                                                    <div> <input type="submit" class="submit" id="submitModif" value="Enregistrer les modifications !" /> </div>
                                                </form>
                                                </div>
                                            </p>
                                        </div>
                                    </div>

                                    <button id="btnSupp" class="btnSupp" onclick="openSupp('<?= $select['SEN_ID'] ?>');">x</button>
                                    <div id="overlaySupp_<?= $select['SEN_ID'] ?>"  class="overlay">
                                        <div id="popup" class="popupSupp">
                                            <h4> 
                                                <div class="titrePopSupp" >Êtes-vous sûre de vouloir supprimer "<?=$select['SEN_NOM']?>" ?</div>
                                                 
                                            </h4>
                                            <div class="textPopSupp">
                                                <span id="btnAnnuler_<?= $select['SEN_ID']?>" class="btnAnnuler">Annuler</span>
                                                <a id="" class="supp" href="../fonction/sensibilisation/suppBdd.php?numId=<?= $select["SEN_ID"]?>">Supprimer</a>
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
            <form class="form" action="../fonction/sensibilisation/insertionBdd.php" method="POST">
                <p><input class="formInput" type="text" id="SEN_NOM" required name="nom" placeholder="NOM"/> </p>
                <div> <input type="submit" class="submit" value="Ajouter !" /> </div>
            </form>
            </div>

</body>

</html>