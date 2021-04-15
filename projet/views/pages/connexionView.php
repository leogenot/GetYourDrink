<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/projet/require.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



var_dump($_SESSION);
if (isset($_POST['btn_login'])) {
    $username    = strip_tags($_REQUEST["txt_username_email"]);    //textbox name "txt_username_email"
    $email        = strip_tags($_REQUEST["txt_username_email"]);    //textbox name "txt_username_email"
    $password    = strip_tags($_REQUEST["txt_password"]);            //textbox name "txt_password"

    UserController::user_logged($username, $email, $password, "/projet/views/pages/choosePlayers.php");
}


?>

<?php ob_start(); ?>
<center>
    <h2>Connexion</h2>

    <form method="post" class="form-horizontal">

        <div>
            <label>Nom d'utilisateur ou E-mail</label>
            <div>
                <input type="text" name="txt_username_email" placeholder="Nom d'utilisateur ou E-mail" required/>
            </div>
        </div>

        <div>
            <label>Mot de passe</label>
            <div>
                <input type="password" name="txt_password" placeholder="Mot de passe" required/>
            </div>
        </div>

        <div>
            <div>
                <input type="submit" name="btn_login" value="Se connecter">
            </div>
        </div>

        <div>
            <div>
                Pas de compte? <a href="/projet/views/pages/registerView.php">
                    <p class="text-info">Créer un compte</p>
                </a>
            </div>
        </div>

    </form>
</center>
<?php //require_once($_SERVER['DOCUMENT_ROOT'] . "/projet/views/layout.php"); ?>