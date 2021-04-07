<?php

require($_SERVER['DOCUMENT_ROOT'] . "/projet/controller/functions.php");
session_start();

//Si l'utilisateur est connecté, on le redirige à la page d'accueil
if (!is_null(get_session('is_authentificate'))) {
    try {
        redirect("./");
    } catch (Exception $exception) {
        die('Erreur : ' . $exception->getMessage());
    }
}

if (isset($_POST['btn_register'])) {
	$username	= strip_tags($_REQUEST['txt_username']);	//textbox name "txt_email"
	$email		= strip_tags($_REQUEST['txt_email']);		//textbox name "txt_email"
	$password	= strip_tags($_REQUEST['txt_password']);       //textbox name "txt_password"

    user_register($username, $email, $password, "/projet/index.php");
}


?>
<?php $title = 'Inscription'; ?>

<?php ob_start(); ?>
<center>
    <h2>Inscription</h2>

    <form method="post" class="form-horizontal">
					
				
				<div class="form-group">
				<label>Nom d'utilisateur</label>
				<div>
				<input type="text" name="txt_username" placeholder="Nom d'utilisateur" />
				</div>
				</div>
				
				<div class="form-group">
				<label>E-mail</label>
				<div>
				<input type="text" name="txt_email" placeholder="E-mail" />
				</div>
				</div>
					
				<div class="form-group">
				<label>Mot de passe</label>
				<div>
				<input type="password" name="txt_password" placeholder="Mot de passe" />
				</div>
				</div>
					
				<div class="form-group">
				<div>
				<input type="submit"  name="btn_register" value="S'inscrire">
				</div>
				</div>
				
				<div class="form-group">
				<div>
				Vous avez déjà un compte? <a href="connexionView.php"><p class="text-info">Se connecter</p></a>		
				</div>
				</div>
					
			</form>
</center>



<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>