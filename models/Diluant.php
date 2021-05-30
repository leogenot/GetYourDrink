<?php
class Diluant
{
   // on définie les attributs de la classe Diluant
  // ils sont publics donc on peut directement y accéder en utilisant $diluant->attribut
  public $id;
  public $name;
  public $dose;

  // fonction constructeur de la classe
  public function __construct($id, $name, $dose)
  {
    $this->id      = $id;
    $this->name  = $name;
    $this->dose = $dose;
  }

    // fonction permettant de retourner une liste de tous les diluants
  public static function all()
  {
    $list = [];
    $db = Db::initDB();
    $req = $db->query('SELECT * FROM diluant');

    foreach ($req->fetchAll() as $diluants) {
      $list[] = new Diluant($diluants['id'], $diluants['name'], $diluants['dose']);
    }

    return $list;
  }

// fonction permettant de récupérer le nombre d'alcool dans la base de données
  static function number_of_diluant()
  {
    $db = Db::initDB();
    $number_of_diluant = $db->query('SELECT COUNT(*) FROM diluant');
    $number_of_diluant->execute();
    return $number_of_diluant->fetchColumn();
  }

    // fonction permettant d'ajouter un diluant à la base de données
  public static function addDiluant($name, $dose, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('INSERT INTO diluant (name, dose) VALUES (:uname,:udose);');

    if ($req->execute(array(':uname' => $name,  ':udose' => $dose))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }
  // fonction permettant de supprimer un diluant de la base de données
  public static function deleteDiluant($id, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('DELETE FROM diluant WHERE id = :uid');

    if ($req->execute(array(':uid' => $id))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }

}