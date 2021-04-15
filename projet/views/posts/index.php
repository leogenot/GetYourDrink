<?php 
//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(UserController::get_session('is_authentificate'))) {
  try {
      FunctionsController::redirect('connexionView.php');
  } catch (Exception $exception) {
      die('Erreur : ' . $exception->getMessage());
  }
}


ob_start(); ?>

<!-- <a href="logout.php">Logout</a> -->

<h1>Voici la liste des cartes (<?php echo Post::number_of_cards()  ?>):</h1>


<?php
foreach ($posts as $post) {
?>
  <div class="container">
    <div class="card">
      <h4 class="date"><?= $post->date ?></h4>
      <p class="content">
        <?= $post->content ?>
      </p>
      <p class="shots">
        <?= $post->shots ?> Gorgées le sang
      </p>
      <a href="/projet/views/likes.php?card_id=<?= $post->id ?>"  id="like">Liker (
        <?= Likes::count_all_likes_by_card_id($post->id) ?>)
      </a>
      <a href='?controller=posts&action=show&id=<?php echo $post->id; ?>'>See content</a>



    </div>
    <hr>
  </div>

<?php
}

?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/projet/views/layout.php"); ?>