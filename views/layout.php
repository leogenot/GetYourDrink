<?php
require($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");
// on définit les variables nécessaires à la page



// Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(user_controller::get_session('is_authentificate'))) {
  try {
      functions_controller::redirect('connexionView.php');
  } catch (Exception $exception) {
      die('Erreur : ' . $exception->getMessage());
  }
}

// Template HTML appelé sur chacune des pages du site (hors pages de connexion)
?>

<DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <title>ALCOOL'IMAC</title>
    <link href="/alcoolimac/projet/public/css/style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
  </head>

  <main>
    
    <header>
    <img id="logo" src=/alcoolimac/projet/public/logo.png />
      <h1>ALCOOL'IMAC</h1>
      <div class="flex">
      <a href='./index.php'>Home</a>
      <a href='?controller=posts&action=index'>Liste des cartes</a>
      <a href='?controller=posts&action=showRandom'>Carte random</a><!-- On affiche dans l'URL l'id généré aléatoirement de la carte que l'on va montrer-->
      <a href='?controller=cocktails&action=index'>Cocktails</a>
      <a href='?controller=alcool&action=index'>Alcool</a>
      <a href='?controller=diluant&action=index'>Diluant</a>
      <a id="logout" href="./views/logout.php">Logout</a>
      
      </div>
    </header>

    <body>

    <?php require_once('routes.php'); ?>
    <script src="/alcoolimac/projet/public/js/script.js"></script>
    </body>


    <footer>
      Copyright AlcoolImac
    </footer>

  </main>
      <html>