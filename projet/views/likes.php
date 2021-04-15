<?php
require($_SERVER['DOCUMENT_ROOT'] . "/projet/require.php");
session_start();

//On recupere l'id de l'card à liker
//La fonction purge nétoie la variable en s'assurant qu'on a pas d'injection
//Cela nous permet d'avoir un nombre ou null, si l'utilisateur tapaait n'imporque quoi dans l'url
$cards_id = (isset($_GET['card_id'])  &&
    (int)FunctionsController::purge($_GET['card_id']) > 0 ) ?
    FunctionsController::purge($_GET['card_id']) : null;

//On verifie si l'id de l'card est différent de null,
// sinon on arrête tout, pas la peine de continuer
try {
    (!is_null($cards_id)) ?
        //On appelle notre fonction de like en lui passant l'id de notre card, à liker
        $error = Likes::likes_cards_by_id($cards_id) : exit();
} catch (Exception $e) {
    $error = $e->getMessage();
}

//On verifie si tout ne s'est bien dérouler, alors on affiche le message d'erreur de retour,
// sinon on fait une redirection vers la page des artiles
if (!is_null($error))
    echo $error;
else
    try {
        
        FunctionsController::redirect($_SERVER['HTTP_REFERER']);
    } catch (Exception $e) {
    }
