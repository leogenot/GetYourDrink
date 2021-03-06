<?php
session_start();
require_once('require.php');


//Si l'utilisateur est connecté, on le redirige à la page d'accueil
if (!is_null(user_controller::get_session('is_authentificate'))) {
  try {
    if (isset($_GET['controller']) && isset($_GET['action'])) {
      $controller = $_GET['controller'];
      $action     = $_GET['action'];
    } else {
      $controller = 'pages';
      $action     = 'home';
    }
  } catch (Exception $exception) {
    die('Erreur : ' . $exception->getMessage());
  }

// Sinon on redirige l'utilisateur vers la page de connexion
} else {
  functions_controller::redirect("/alcoolimac/projet/views/pages/connexionView.php");
}

require_once('views/layout.php');
?>