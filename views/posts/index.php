<?php 
//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(user_controller::get_session('is_authentificate'))) {
  try {
      functions_controller::redirect('connexionView.php');
  } catch (Exception $exception) {
      die('Erreur : ' . $exception->getMessage());
  }
}


if (isset($_POST['btn_add'])) {
  $content    = strip_tags($_REQUEST["txt_card"]);    //textbox name "txt_username_email"
  $shots        = strip_tags($_REQUEST["nb_shots"]);    //textbox name "txt_username_email"           //textbox name "txt_password"

  Post::addCard($content, $shots, "/alcoolimac/projet/");
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
      <a href="/alcoolimac/projet/views/likes.php?card_id=<?= $post->id ?>"  id="like">Liker (
        <?= Likes::count_all_likes_by_card_id($post->id) ?>)
      </a>
      <a href='?controller=posts&action=show&id=<?php echo $post->id; ?>'>See content</a>
      <a href='?controller=posts&action=remove&id=<?php echo $post->id; ?>'>Remove</a>



    </div>
    <hr>
  </div>

<?php
}
?>

<h2>Ajouter une carte</h2>

    <form method="post" class="form-horizontal">

        <div>
            <label>Texte de la carte</label>
            <div>
                <input type="text" name="txt_card" placeholder="Texte de la carte" required/>
            </div>
        </div>

        <div>
            <label>Nombre de gorgées</label>
            <div>
                <input type="number" name="nb_shots" placeholder="Nombre de gorgées" required/>
            </div>
        </div>

        <div>
            <div>
                <input type="submit" name="btn_add" value="Ajouter">
            </div>
        </div>

    </form>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/views/layout.php"); ?>