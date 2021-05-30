<?php 
//Si l'utilisateur nest pas connecté, on le redirige à la page de connexion
if (is_null(user_controller::get_session('is_authentificate'))) {
  try {
      functions_controller::redirect('connexionView.php');
  } catch (Exception $exception) {
      die('Erreur : ' . $exception->getMessage());
  }
}

// On récupère les données entrées par un utilisateur voulant créer un alcool

if (isset($_POST['btn_add'])) {
  $name = strip_tags($_REQUEST["alcool_name"]);    //textbox name "txt_username_email"
  $degree = strip_tags($_REQUEST["alcool_degree"]);    //textbox name "txt_username_email"           //textbox name "txt_password"
  $dose = strip_tags($_REQUEST["alcool_dose"]);  

  Alcool::addAlcool($name, $degree, $dose, "/alcoolimac/projet/");
}

ob_start(); ?>

<html>
<body>
<h3>Voici la liste des alcools ! (<?php echo Alcool::number_of_alcool()  ?>):</h3>
<h4>N'hésite pas à en ajouter pour créer ton cocktail préféré !</h4>

<?php
// pour chaque alcool on affiche le template html ci-dessous
foreach ($alcools as $alcool) {
?>

  <div class="container">
    <div class="alcool">
      <h4 class="id"><?= $alcool->name ?></h4>
      <p>Degré : <?= $alcool->degree ?></p>
      <p>Dose recommandée (en cl): <?= $alcool->dose ?></p>
      <a href='?controller=alcool&action=remove&id=<?php echo $alcool->id; ?>'>Remove</a>

    </div>
    <hr>
  </div>

<?php
}
?>

<h2>Ajouter un alcool</h2>

    <form method="post" class="form-horizontal">

        <div>
            <label>Nom de l'alcool</label>
            <div>
                <input type="text" name="alcool_name" placeholder="Nom de l'alcool" required/>
            </div>
        </div>

        <div>
            <label>Dégré de l'alcool</label>
            <div>
                <input type="text" name="alcool_degree" placeholder="Degré" required/>
            </div>
        </div>

        <div>
        <label>Dose recommandée en cl</label>
            <div>
                <input type="text" name="alcool_dose" placeholder="Dose alcool" required/>
            </div>
        </div>

        <div>
            <div>
                <input type="submit" name="btn_add" value="Ajouter">
            </div>
        </div>

    </form>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/views/layout.php"); ?>