<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");


//On recupere l'id de l'card à liker
//La fonction purge nettoie la variable en s'assurant qu'on a pas d'injection
//Cela nous permet d'avoir un nombre (ou null si l'utilisateur tape n'imporque quoi dans l'url)
$cards_id = (isset($_GET['card_id'])  &&
    (int)functions_controller::purge($_GET['card_id']) > 0 ) ?
    functions_controller::purge($_GET['card_id']) : null;

//On verifie si l'id de la card est différent de null,
// sinon on arrête tout, pas la peine de continuer
try {
    (!is_null($cards_id)) ?
        //On appelle notre fonction de like en lui passant l'id de notre card, à liker
        $error = Likes::likes_cards_by_id($cards_id) : exit();
} catch (Exception $e) {
    $error = $e->getMessage();
}

//On verifie que tout ne s'est bien dérouler, sinon on affiche le message d'erreur de retour,
//Si tout s'est bien déroullé on fait une redirection vers la page des cartes
if (!is_null($error))
    echo $error;
else
    try {
        
        functions_controller::redirect($_SERVER['HTTP_REFERER']);
    } catch (Exception $e) {
    }
