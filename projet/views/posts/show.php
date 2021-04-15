<p>This is the requested post:</p>

<div class="container">
    <div class="card">
      <h4 class="date"><?= $post->date ?></h4>
      <p class="content">
        <?= $post->content ?>
      </p>
      <p class="shots">
        <?= $post->shots ?> Gorgées le sang
      </p>
      <a href="/projet/views/likes.php?card_id=<?= $post->id ?>" id="like">Liker (
        <?= Likes::count_all_likes_by_card_id($post->id) ?>)
      </a>



    </div>
    <hr>
  </div>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/projet/views/layout.php"); ?>