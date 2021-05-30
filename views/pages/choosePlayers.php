<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");


//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(user_controller::get_session('is_authentificate'))) {
    try {
        functions_controller::redirect('connexionView.php');
    } catch (Exception $exception) {
        die('Erreur : ' . $exception->getMessage());
    }
}

// On récupère le nom des joueurs temporaires grâce à une méthode POST

if (isset($_POST['btn_save_players'])) {
    $username    = strip_tags($_REQUEST["txt_player_name1"]);    //textbox name "txt_player_name1"  
    //$username    = strip_tags($_REQUEST["txt_player_name2"]);    //textbox name "txt_player_name2"  
    //$username    = strip_tags($_REQUEST["txt_player_name3"]);    //textbox name "txt_player_name3"  
    //$username    = strip_tags($_REQUEST["txt_player_name4"]);    //textbox name "txt_player_name4"  

    tempuser_controller::register_temp_user($username, "/alcoolimac/projet/index.php");
}
?>

<?php ob_start(); ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Choix des joueurs</title>
  <link rel="stylesheet" href="../../public/css/style.css">
  <script src="/alcoolimac/projet/public/js/script.js"></script>
</head>

<body>
    <div>
    <h1>ALCOOL'IMAC</h1>
<h2>Entrez les joueurs</h2>

<div class="column">
<label>Selection du nombre de joueurs</label>
<select class="inputForm" id="number-of-players" name="select">
    <option value="" disabled selected>Nombre de joueurs (max. 4)</option>
    <option value="1">1 joueur</option>
    <option value="2">2 joueurs</option>
    <option value="3">3 joueurs</option>
    <option value="4">4 joueurs</option>
</select>
</div>


<form method="post" class="form-players" >
    <div>
        <div class="player-number">
            <div id="player-1" class="player-1">Joueur 1 : <input class="inputForm" type="text" id="name1" name="txt_player_name1" placeholder="username" ></div><!-- 
            <div id="player-2" class="player-2">Joueur 2 : <input type="text" id="name2" name="txt_player_name2" placeholder="username" ></div>
            <div id="player-3" class="player-3">Joueur 3 : <input type="text" id="name3" name="txt_player_name3" placeholder="username" ></div>
            <div id="player-4" class="player-4">Joueur 4 : <input type="text" id="name4" name="txt_player_name4" placeholder="username" ></div> -->
        </div>
    </div>


    <div>
        <input class="buttonForm" type="submit" name="btn_save_players" value="Enregistrer">
    </div>


</form>
    </div>

</body>
</html>
