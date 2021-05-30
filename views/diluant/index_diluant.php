<?php 
//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(user_controller::get_session('is_authentificate'))) {
  try {
      functions_controller::redirect('connexionView.php');
  } catch (Exception $exception) {
      die('Erreur : ' . $exception->getMessage());
  }
}

// On récupère les données entrées par un utilisateur voulant créer un diluant
if (isset($_POST['btn_add'])) {
  $name = strip_tags($_REQUEST["diluant_name"]);  
  $dose = strip_tags($_REQUEST["diluant_dose"]);  

  Diluant::addDiluant($name, $dose, "/alcoolimac/projet/");
}

ob_start(); ?>

<!-- <a href="logout.php">Logout</a> -->
<html>
<body>
<h3>Voici la liste des diluants ! (<?php echo Diluant::number_of_diluant()  ?>):</h3>
<h4>N'hésite pas à en ajouter pour créer ton cocktail préféré !</h4>

<?php
// pour chaque diluant on affiche le template html ci-dessous
foreach ($diluants as $diluant) {
?>

  <div class="container">
    <div class="diluant">
      <h4 class="id"><?= $diluant->name ?></h4>
      <p>Dose recommandée (en cl): <?= $diluant->dose ?></p>
      <a href='?controller=diluant&action=remove&id=<?php echo $diluant->id; ?>'>Remove</a>

    </div>
    <hr>
  </div>

<?php
}
?>

<h2>Ajouter un diluant</h2>

    <form method="post" class="form-horizontal">

        <div>
            <label>Nom du diluant</label>
            <div>
                <input type="text" name="diluant_name" placeholder="Nom du diluant" required/>
            </div>
        </div>

        <div>
        <label>Dose recommandée en cl</label>
            <div>
                <input type="text" name="diluant_dose" placeholder="Dose diluant" required/>
            </div>
        </div>

        <div>
            <div>
                <input type="submit" name="btn_add" value="Ajouter">
            </div>
        </div>

    </form>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/views/layout.php"); ?>