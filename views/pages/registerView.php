<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");


// On récupère les données d'inscription de l'utilisateur
// la fonction user_register va vérifier que les données inscrites correspondent à ce qui est attendu

if (isset($_POST['btn_register'])) {
	$username	= strip_tags($_REQUEST['txt_username']);	//textbox name "txt_email"
	$email		= strip_tags($_REQUEST['txt_email']);		//textbox name "txt_email"
	$password	= strip_tags($_REQUEST['txt_password']);       //textbox name "txt_password"

	user_controller::user_register($username, $email, $password, "/alcoolimac/projet/index.php");
}

?>

<?php $title = 'Inscription'; ?>

<?php ob_start(); ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="../../public/css/style.css">
  <script src="/alcoolimac/projet/public/js/script.js"></script>
</head>
<body>
	<div>
		<h1>ALCOOL'IMAC</h1>
	<h2>Inscription</h2>

	<form method="post" class="form-horizontal">


		<div class="form-group">
			<label>Nom d'utilisateur</label>
			<div>
				<input class="inputForm" type="text" name="txt_username" placeholder="Nom d'utilisateur" required/>
			</div>
		</div>

		<div class="form-group">
			<label>E-mail</label>
			<div>
				<input class="inputForm" type="text" name="txt_email" placeholder="E-mail" required/>
			</div>
		</div>

		<div class="form-group">
			<label>Mot de passe</label>
			<div>
				<input class="inputForm" type="password" name="txt_password" placeholder="Mot de passe" required/>
			</div>
		</div>

		<div class="form-group">
			<div>
				<input class="buttonForm" type="submit" name="btn_register" value="S'inscrire">
			</div>
		</div>

		<div class="form-group">
			<div>
				Vous avez déjà un compte ? <a href="connexionView.php">
					<p class="text-info">Se connecter</p>
				</a>
			</div>
		</div>

	</form>
	</div>
</body>
</html>