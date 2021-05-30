<?php   
// On démarre la session pour permettre à l'utilisateur de se connecter

session_start();
$_SESSION = [];
session_unset();
session_destroy();
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");



// On récupère les données de connexion entrées par l'utilisateur
// en appelant la fonction user_logged on vérifie que les données correspondent à celles de la base

if (isset($_POST['btn_login'])) {
    $username    = strip_tags($_REQUEST["txt_username_email"]);    
    $email        = strip_tags($_REQUEST["txt_username_email"]);   
    $password    = strip_tags($_REQUEST["txt_password"]);     

    user_controller::user_logged($username, $email, $password, "/alcoolimac/projet/views/pages/choosePlayers.php");
}


?>

<?php ob_start(); ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="../../public/css/style.css">
  <script src="/alcoolimac/projet/public/js/script.js"></script>
</head>
<body>
    <div>

<h1>ALCOOL'IMAC</h1>
    <h2>Connexion</h2>

    <form method="post" class="form-horizontal">

        <div>
            <label>Nom d'utilisateur ou e-mail</label>
            <div>
                <input class="inputForm" type="text" name="txt_username_email" placeholder="Nom d'utilisateur ou e-mail" required/>
            </div>
        </div>

        <div>
            <label>Mot de passe</label>
            <div>
                <input class="inputForm" type="password" name="txt_password" placeholder="Mot de passe" required/>
            </div>
        </div>

        <div>
            <div>
                <input class="buttonForm" type="submit" name="btn_login" value="Se connecter">
            </div>
        </div>

        <div>
            <div>
                Pas de compte ? <a href="/alcoolimac/projet/views/pages/registerView.php">
                    <p class="text-info">Créer un compte</p>
                </a>
            </div>
        </div>

    </form>
    </div>
</body>
</html>