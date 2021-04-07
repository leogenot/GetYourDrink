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

if (isset($_POST['btn_login'])) {
    $username    = strip_tags($_REQUEST["txt_username_email"]);    //textbox name "txt_username_email"
    $email        = strip_tags($_REQUEST["txt_username_email"]);    //textbox name "txt_username_email"
    $password    = strip_tags($_REQUEST["txt_password"]);            //textbox name "txt_password"

    user_logged($username, $email, $password, "/projet/index.php");
}


?>
<?php $title = 'Connexion'; ?>

<?php ob_start(); ?>
<center>
    <h2>Connexion</h2>

    <form method="post" class="form-horizontal">

        <div>
            <label>Nom d'utilisateur ou E-mail</label>
            <div>
                <input type="text" name="txt_username_email" placeholder="Nom d'utilisateur ou E-mail" />
            </div>
        </div>

        <div>
            <label>Mot de passe</label>
            <div>
                <input type="password" name="txt_password" placeholder="Mot de passe" />
            </div>
        </div>

        <div>
            <div>
                <input type="submit" name="btn_login" value="Se connecter">
            </div>
        </div>

        <div>
            <div>
                Pas de compte? <a href="registerView.php">
                    <p class="text-info">Créer un compte</p>
                </a>
            </div>
        </div>

    </form>
</center>



<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>