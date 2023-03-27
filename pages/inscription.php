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
	<div class="carre" id="carreInscription">
		
			<h3>Inscription</h3>
			<div class="formInscription">
				<form class="form" id="formInscription" action="../fonction/inscrip.php" method="POST">
					<p>
						<input class="formInput" required type=text placeholder="NOM" name="nom" value=""><br><br>
						<input class="formInput" required type=text placeholder="Prénom" name="prenom" value=""><br><br>
						<input class="formInput" type=text placeholder="Numéro de sécurité sociale" name="secu" value=""><br><br>
						<input class="formInput" required type=text placeholder="Email" name="mail" value=""><br><br>
						<input class="formInput" required type=text placeholder="Login" name="login" value=""><br><br>
						<input class="formInput" required type=password placeholder="Mot de passe" name="mdp" value=""><br><br>
						<input class="formInput" required type=password placeholder="Confirmer votre mot de passe" name="confirmMdp" value=""><br><br>
						<input class="submit" id="submitInscription" type=submit value="Je m'inscris !">
					</p>
				</form>
			</div>
		
	</div>
	</main>
</body>

</html>