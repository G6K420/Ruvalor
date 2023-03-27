<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ruvalor</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
	<h1><a href="../index.php">Ruvalor</a></h1>
	
		<main>
            <div class="carre" id="carreConnexion">
                <div>
			         <h3>Connexion</h3>
                </div>
                <div class="formConnexion">
        			<form class="form" action="../fonction/connect.php" method="POST">
        				<p>
                            
        					<input class="formInput" required type=text placeholder="Login" name="login" value=""><br><br>
        					<input class="formInput" required type=password placeholder="Mot de passe" name="mdp" value=""><br><br>
                            
        					<input class="submit" id="submitConnexion" type=submit value="Je me connecte !">

        				</p>
        			</form>
                </div>
                <div>
                    <p>
                        Vous n'avez pas de compte ?<br><br>
                        <a href="inscription.php" class="submit"> Inscrivez-vous !</a>
                    </p>
                </div>
            </div>  
		</main>
</body>

</html> 