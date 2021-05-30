<?php
class Alcool
{
  // on définie les attributs de la classe Alcool
  // ils sont publics donc on peut directement y accéder en utilisant $alcool->attribut
  public $id;
  public $name;
  public $degree;
  public $dose;

  // fonction constructeur de la classe
  public function __construct($id, $name, $degree, $dose)
  {
    $this->id      = $id;
    $this->name  = $name;
    $this->degree = $degree;
    $this->dose = $dose;
  }

  // fonction permettant de retourner une liste de tous les alcools
  public static function all()
  {
    $list = [];
    $db = Db::initDB();
    $req = $db->query('SELECT * FROM alcool');

    // on créer une list des objets Alcool depuis le résultat de la base de données
    foreach ($req->fetchAll() as $alcools) {
      $list[] = new Alcool($alcools['id'], $alcools['name'], $alcools['degree'], $alcools['dose']);
    }

    return $list;
  }

// fonction permettant de récupérer le nombre d'alcool dans la base de données
  static function number_of_alcool()
  {
    $db = Db::initDB();
    $number_of_alcool = $db->query('SELECT COUNT(*) FROM alcool');
    $number_of_alcool->execute();
    return $number_of_alcool->fetchColumn();
  }

// fonction permettant d'ajouter un alcool à la base de données
  public static function addAlcool($name, $degree, $dose, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('INSERT INTO alcool (name, degree, dose) VALUES (:uname,:udegree,:udose);');

    if ($req->execute(array(':uname' => $name, ':udegree' => $degree, ':udose' => $dose))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }

// fonction permettant de supprimer un alcool de la base de données
  public static function deleteAlcool($id, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('DELETE FROM alcool WHERE id = :uid');

    // la requête a été préparée, maintenant on remplace :id par notre valeur actuelle $id
    if ($req->execute(array(':uid' => $id))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }
}