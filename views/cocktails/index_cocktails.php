<?php 
//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(user_controller::get_session('is_authentificate'))) {
  try {
      functions_controller::redirect('connexionView.php');
  } catch (Exception $exception) {
      die('Erreur : ' . $exception->getMessage());
  }
}

// On récupère les données entrées par un utilisateur voulant créer un cocktails

if (isset($_POST['btn_add'])) {
  $alcool = strip_tags($_REQUEST["alcool_cocktail"]);  
  $diluant = strip_tags($_REQUEST["diluant_cocktail"]); 
  $createur = strip_tags($_REQUEST["createur_cocktail"]);            

  Cocktails::addCocktails($alcool, $diluant, $createur, "/alcoolimac/projet/");
}


ob_start(); ?>

<html>
<body>
<h3>Voici la liste des cocktails ! (<?php echo Cocktails::number_of_cocktails()  ?>):</h3> <!-- On affiche le nombre de cocktails -->
<h4>N'hésite pas à t'en inspirer ou à créer ton cocktail préféré 😘</h4>

<?php
// pour chaque cocktails on affiche le template html ci-dessous
foreach ($cocktails as $cocktail) {
?>

  <div class="container">
    <div class="cocktail">
      <h4 class="id">Cocktail <?= $cocktail->id ?></h4>
      <p>Pour ce cocktail mélangez :</p>
      <p><?= $cocktail->alcool_id ?></p>
      <p> avec </p>
      <p><?= $cocktail->diluant_id ?></p>
      <p>(voir doses recommandées dans les pages alcools et diluants)</p>
      <p>Ce cocktail a été créé par : <?= $cocktail->user ?></p>
      <a href='?controller=cocktails&action=remove&id=<?php echo $cocktail->id; ?>'>Remove</a>

    </div>
    <hr>
  </div>

<?php
}
?>

<h2>Ajouter un cocktail</h2>

    <form method="post" class="form-horizontal">
    <div>
            <label>Alcool</label>
            <select name="alcool_cocktail" required>
              <option value="">Choisissez un alcool</option>
              
              <?php
foreach ($alcools as $alcool) {
?>
      <option value="<?=$alcool->id?>"><?= $alcool->name?></option>

<?php
}
?>

</select>              
        </div>

        <div>
            <label>Diluant</label>
            <select name="diluant_cocktail" required>
              <option value="">Choisissez un diluant</option>
              
            

<?php
foreach ($diluants as $diluant) {
?>
<option value="<?= $diluant->id?>"><?= $diluant->name?></option>
              
<?php
}
?>

</select>
        </div>

        <label>Créateur</label>
            <div>
                <input type="text" name="createur_cocktail" placeholder="Créateur" required/>
            </div>
        </div>

        <div>
            <div>
                <input type="submit" name="btn_add" value="Ajouter">
            </div>
        </div>

    </form>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/views/layout.php"); ?>