<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ruvalor</title>
    <?php 
        session_start(); 
    ?>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <h1>Ruvalor</h1>

    <div class="infoConnexion">
        <div class="connect">
            <?php
                echo "Vous êtes connecté sur le compte de ".$_SESSION['session']."";
            ?>
        </div>
        <div class="deconnect" >
            <form action="../fonction/deconnexion.php" method="post">
                <input class="submit" id="submitDeconnexion" type="submit" value="Déconnexion" />
            </form>
        </div>
    </div>    
    <main>
    <div class="rectangle">
            <ul>
                <li>
                    <a href="employe.php">Employé</a>
                </li> 
                <li>
                    <a href="metier.php">Métier</a>
                </li> 
                <li>
                    <a href="formation.php">Formation</a>
                </li> 
                <li>
                    <a href="sensibilisation.php">Sensibilisation</a>
                </li> 
            </ul>
    </div>
</main>
</body>

</html>