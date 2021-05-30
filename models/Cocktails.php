<?php
class Cocktails
{
   // on définie les attributs de la classe Cocktails
  // ils sont publics donc on peut directement y accéder en utilisant $cocktails->attribut
  public $id;
  public $alcool_id;
  public $diluant_id;
  public $user;

  // fonction constructeur de la classe
  public function __construct($id, $alcool_id, $diluant_id, $user)
  {
    $this->id      = $id;
    $this->alcool_id  = $alcool_id;
    $this->diluant_id = $diluant_id;
    $this->user = $user;
  }

    // fonction permettant de retourner une liste de tous les coktails
    // on utilise une jointure SQL afin de récupérer les noms des alcools et diluants présents dans les cocktails et pas juste leur id
  public static function all()
  {
    $list = [];
    $db = Db::initDB();

    $reqb = $db->query('SELECT  alcool.name as a_name , diluant.name as d_name  , cocktails.id, cocktails.user FROM alcool, diluant INNER JOIN cocktails WHERE alcool.id = cocktails.alcool_id AND diluant.id = cocktails.diluant_id');
    foreach ($reqb->fetchAll() as $cocktails) { 
      $list[] = new Cocktails($cocktails['id'], $cocktails['a_name'], $cocktails['d_name'], $cocktails['user']);
    }

    return $list;
  }

// fonction permettant de récupérer le nombre de cocktails dans la base de donnéess
  static function number_of_cocktails()
  {
    $db = Db::initDB();
    $number_of_cocktails = $db->query('SELECT COUNT(*) FROM cocktails');
    $number_of_cocktails->execute();
    return $number_of_cocktails->fetchColumn();
  }

  // fonction permettant d'ajouter un cocktail à la base de données
  public static function addCocktails($alcool_id, $diluant_id, $user, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('INSERT INTO cocktails (alcool_id, diluant_id, user) VALUES (:ualcool_id,:udiluant_id,:uuser);');

    if ($req->execute(array(':ualcool_id' => $alcool_id, ':udiluant_id' => $diluant_id, ':uuser' => $user))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }

  // fonction permettant de supprimer un cocktail de la base de données
  public static function deleteCocktails($id, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('DELETE FROM cocktails WHERE id = :uid');

    if ($req->execute(array(':uid' => $id))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }
}