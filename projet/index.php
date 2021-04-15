<?php


require_once('require.php');



if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
//Si l'utilisateur est connecté, on le redirige à la page d'accueil
if (!is_null(UserController::get_session('is_authentificate'))) {
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
} else {
  var_dump(UserController::get_session('is_authentificate'));
  FunctionsController::redirect("./views/pages/connexionView.php");
}







require_once('views/layout.php');
