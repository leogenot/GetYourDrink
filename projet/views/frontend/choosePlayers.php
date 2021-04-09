<?php

require($_SERVER['DOCUMENT_ROOT'] . "/projet/controller/functions.php");
session_start();

//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(get_session('is_authentificate'))) {
    try {
        redirect('views/frontend/connexionView.php');
    } catch (Exception $exception) {
        die('Erreur : ' . $exception->getMessage());
    }
}

if (isset($_POST['btn_save_players'])) {
    $username    = strip_tags($_REQUEST["txt_player_name1"]);    //textbox name "txt_player_name1"  
    //$username    = strip_tags($_REQUEST["txt_player_name2"]);    //textbox name "txt_player_name2"  
    //$username    = strip_tags($_REQUEST["txt_player_name3"]);    //textbox name "txt_player_name3"  
    //$username    = strip_tags($_REQUEST["txt_player_name4"]);    //textbox name "txt_player_name4"  

    register_temp_user($username, "/projet/index.php");
}
?>

<?php $title = 'Choix des joueurs'; ?>
<?php ob_start(); ?>

<a href="../../logout.php">Logout</a>


<h1>Entrez les joueurs:</h1>


<select id="number-of-players" name="select">
    <option value="" disabled selected>Nombre de joueurs (max. 4)</option>
    <option value="1">1 joueur</option>
    <option value="2">2 joueurs</option>
    <option value="3">3 joueurs</option>
    <option value="4">4 joueurs</option>
</select>
<label>Selection du nombre de joueurs</label>

<form method="post" class="form-players">
    <div>
        <div class="player-number">
            <div id="player-1" class="player-1">joueur 1 : <input type="text" id="name1" name="txt_player_name1" placeholder="username" ></div><!-- 
            <div id="player-2" class="player-2">joueur 2 : <input type="text" id="name2" name="txt_player_name2" placeholder="username" ></div>
            <div id="player-3" class="player-3">joueur 3 : <input type="text" id="name3" name="txt_player_name3" placeholder="username" ></div>
            <div id="player-4" class="player-4">joueur 4 : <input type="text" id="name4" name="txt_player_name4" placeholder="username" ></div> -->
        </div>
    </div>


    <div>
        <input type="submit" name="btn_save_players" value="Enregistrer">
    </div>
</form>










<?php $content = ob_get_clean(); ?>



<?php require('template.php'); ?>