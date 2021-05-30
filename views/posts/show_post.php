<?php
require($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");

?>

<p>Vous êtes à <span id="myDrinks"></span> gorgées à vous tous la team !</p>


<p>This is the requested card:</p>

<div class="container">
    <div class="card">
      <h4 class="date"><?= $post->date ?></h4>
      <p class="content">
        <?= $post->content ?>
      </p>
      <p>
        <span id="shots"><?= $post->shots ?></span> Gorgées le sang
      </p>
      <a href="/alcoolimac/projet/views/likes.php?card_id=<?= $post->id ?>" id="like">Liker (
        <?= Likes::count_all_likes_by_card_id($post->id) ?>)
      </a>
      <a href="#"><button id="drink" onclick="getCountDrink()"> J'ai bu </button>
      </a>
      <a href='?controller=posts&action=showRandom' id="change"> Changer de carte
      </a>



    </div>
    <hr>
  </div>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/views/layout.php"); ?>