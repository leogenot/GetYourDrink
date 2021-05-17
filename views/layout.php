<?php
require($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");
$max = Post::get_card_max_id();
$min = Post::get_card_min_id();
$id = rand($min, $max);




//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(user_controller::get_session('is_authentificate'))) {
  try {
      functions_controller::redirect('connexionView.php');
  } catch (Exception $exception) {
      die('Erreur : ' . $exception->getMessage());
  }
}

var_dump($_SESSION['user_id']);
?>

<DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <link href="/alcoolimac/projet/public/css/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="/alcoolimac/projet/public/js/script.js"></script>
  </head>

  <body>
    <header>
      <a href='./index.php'>Home</a>
      <a href='?controller=posts&action=index'>Liste des cartes</a>
      <a href='?controller=posts&action=show&id=<?php echo $id; ?>'>Carte random</a>
      <a href="./views/logout.php">Logout</a>
      <a>Tyé à <?php //echo UserModel::get_number_of_shots($_SESSION['user_id'])  ?> gorgées bues 😘</a>
    </header>

    <?php require_once('routes.php'); ?>
  
    <footer>
      Copyright AlcoolImac
    </footer>

    </body>
      <html>