<?php

session_start();

//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(get_session('is_authentificate'))){
    try {
        redirect('views/frontend/connexionView.php');
    } catch (Exception $exception) {
        die('Erreur : ' . $exception->getMessage());

    }
}
?>

<?php $title = 'Toutes les cartes'; ?>
<?php ob_start(); ?>

<a href="logout.php">Logout</a>


<h1>Voici la liste des cartes (<?php echo number_of_cards() ?>):</h1>


<?php
while ($data = $card->fetch())
{
?>
<div class="container">
       <div class="card">
           <h4 class="date"><?= purge($data['date']) ?></h4>
           <p class="content">
               <?= purge($data['content']) ?>
           </p>
           <p class="shots">
               <?= $data['shots'] ?> Gorgées le sang
           </p>
           <a href="likes.php?card_id=<?= $data['id'] ?>" class="liker">Liker (<?= count_all_likes_by_card_id($data['id']) ?>)</a>
       </div>
        <hr>
</div>


<?php

}
$card->closeCursor();
?>

<?php $content = ob_get_clean(); ?>



<?php require('template.php'); ?>

