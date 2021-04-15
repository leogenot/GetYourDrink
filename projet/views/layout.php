<?php
require($_SERVER['DOCUMENT_ROOT'] . "/projet/require.php");
$min = 1;
$max = Post::number_of_cards();;
$id = rand($min, $max);


//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(UserController::get_session('is_authentificate'))) {
  try {
      FunctionsController::redirect('connexionView.php');
  } catch (Exception $exception) {
      die('Erreur : ' . $exception->getMessage());
  }
}


?>

<DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <link href="/projet/public/css/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="/projet/public/js/script.js"></script>
  </head>

  <body>
    <header>
      <a href='./index.php'>Home</a>
      <a href='?controller=posts&action=index'>Liste des cartes</a>
      <a href='?controller=posts&action=show&id=<?php echo $id; ?>'>Carte random</a>
      <a href="./views/logout.php">Logout</a>
    </header>

    <?php require_once('routes.php'); ?>
  
    <footer>
      Copyright AlcoolImac
    </footer>

    </body>
      <html>