<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");





var_dump($_SESSION);

if (isset($_POST['btn_register'])) {
	$username	= strip_tags($_REQUEST['txt_username']);	//textbox name "txt_email"
	$email		= strip_tags($_REQUEST['txt_email']);		//textbox name "txt_email"
	$password	= strip_tags($_REQUEST['txt_password']);       //textbox name "txt_password"

	user_controller::user_register($username, $email, $password, "/alcoolimac/projet/index.php");
}


?>
<?php $title = 'Inscription'; ?>

<?php ob_start(); ?>
<center>
	<h2>Inscription</h2>

	<form method="post" action="" class="form-horizontal">


		<div class="form-group">
			<label>Nom d'utilisateur</label>
			<div>
				<input type="text" name="txt_username" placeholder="Nom d'utilisateur" required/>
			</div>
		</div>

		<div class="form-group">
			<label>E-mail</label>
			<div>
				<input type="text" name="txt_email" placeholder="E-mail" required/>
			</div>
		</div>

		<div class="form-group">
			<label>Mot de passe</label>
			<div>
				<input type="password" name="txt_password" placeholder="Mot de passe" required/>
			</div>
		</div>

		<div class="form-group">
			<div>
				<input type="submit" name="btn_register" value="Sinscrire">
			</div>
		</div>

		<div class="form-group">
			<div>
				Vous avez déjà un compte? <a href="connexionView.php">
					<p class="text-info">Se connecter</p>
				</a>
			</div>
		</div>

	</form>
</center>
<?php //require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/views/layout.php"); ?>