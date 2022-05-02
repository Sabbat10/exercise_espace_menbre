<?php 
	
	$bdd = new PDO('mysql:host=localhost;dbname=exercise;charset=utf8', 'root', '');
	
	if (!empty($_POST['pseudo']) AND !empty($_POST['password']) AND !empty($_POST['password_two'])) {

			//variables
			$pseudo = htmlspecialchars($_POST['pseudo']);
			$password = sha1($_POST['password']);
			$password_two = sha1($_POST['password_two']);

			// vérifications de deux mot de passe
			if ($password == $password_two) {

					// Vérification que le pseudo est déjà utiliser
					$requette = $bdd->prepare('SELECT * FROM utilisateurs WHERE pseudo = ?');
					$requette->execute([$pseudo]);
					$donnees = $requette->rowCount();

					if ($donnees == 0) {
							
							// Insertion de données dans la BDD
							$requette = $bdd->prepare('INSERT INTO utilisateurs(pseudo, password) VALUES(?, ?)');
							$requette->execute([$pseudo, $password]);

							?>
								<div class="succes">
									<?php $succes = 'Felicitation !'; ?> 		
								</div>
							<?php

					}else{
						$msg = 'Ce pseudo est déjà utiliser !';
					}
				
			}else{
				$msg = 'Les deux mot de passe ne correspondent pas !';
			}
			
		}else{
			$msg = 'Tous les champs doivent complétés !';
		}

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="index.css">
	<title></title>
</head>
<body>

	<center>
		<h1>Incrivez-vous</h1>

		<form method="post" action="">
			<p>
				<label for="pseudo">Pseudo :</label><br>
				<input type="text" name="pseudo" id="pseudo">
			</p>
			<p>
				<label for="mdp">Mot de passe :</label><br>
				<input type="password" name="password" id="password">
			</p>
			<p>
				<label for="password_two">Confirmation du mot de passe :</label><br>
				<input type="password" name="password_two" id="password_two">
			</p>
			<p><input type="submit" name=""></p>

			<?php 

				?>
					<div class="msg">
						<?php 

							if (isset($msg)) {
								echo $msg;
							}

						 ?>
					</div>
					<div class="succes">
						<?php 

							if (isset($succes)) {
								
								?>
									<b><?php echo $succes ?>  <a href="">Connetez-vous</a></b>
								<?php
							}

						 ?>
					</div>

				<?php

			 ?>
		</form>
	</center>

</body>
</html>