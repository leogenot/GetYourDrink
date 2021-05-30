<?php
class Post
{
  // on définie les attributs de la classe Post
  // ils sont publics donc on peut directement y accéder en utilisant $post->attribut
  public $id;
  public $date;
  public $content;
  public $shots;

  // fonction constructeur de la classe
  public function __construct($id, $date, $content, $shots)
  {
    $this->id      = $id;
    $this->date  = $date;
    $this->content = $content;
    $this->shots = $shots;
  }

    // fonction permettant de retourner une liste de toutes les cards
  public static function all()
  {
    $list = [];
    $db = Db::initDB();
    $req = $db->query('SELECT * FROM card');

    foreach ($req->fetchAll() as $post) {
      $list[] = new Post($post['id'], $post['date'], $post['content'], $post['shots']);
    }

    return $list;
  }

  // fonction permettant de récupérer une card selon son id
  public static function find($id)
  {
    $db = Db::initDB();
    // on vérifie que l'id est un entier
    $id = intval($id);
    $req = $db->prepare('SELECT * FROM card WHERE id = :uid');
    // the query was prepared, now we replace :id with our actual $id value
    $req->execute(array(':uid' => $id));
    $post = $req->fetch();

    return new Post($post['id'], $post['date'], $post['content'], $post['shots']);
  }

  // fonction permettant de récupérer une card selon son id
  public static function findRandom()
  {
    $db = Db::initDB();
    $req = $db->prepare('SELECT * FROM card ORDER BY rand() ');
    // the query was prepared, now we replace :id with our actual $id value
    $req->execute();
    $post = $req->fetch();

    return new Post($post['id'], $post['date'], $post['content'], $post['shots']);
  }

  // fonction permettant de récupérer le nombre de cards dans la base de données
  static function number_of_cards()
  {
    $db = Db::initDB();
    $number_of_cards = $db->query('SELECT COUNT(*) FROM card');
    $number_of_cards->execute();
    return $number_of_cards->fetchColumn();
  }


  // fonction permettant d'ajouter une card à la base de données
  public static function addCard($content, $shots, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('INSERT INTO card (date, content, shots) VALUES (now(),:ucontent,:ushots);');

    if ($req->execute(array(':ucontent' => $content, ':ushots' => $shots))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }

  // fonction permettant de supprimer une card de la base de données
  public static function deleteCard($id, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('DELETE FROM card WHERE id = :uid');

    if ($req->execute(array(':uid' => $id))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }

  // fonction permettant de récupérer l'id minimal des cards
  public static function get_card_min_id()
  {
    $db = Db::initDB();
    $minId = $db->query('SELECT MIN(id) AS MinIdNumber FROM card');
    $minId->execute();
    return $minId->fetchColumn();
  }

  // fonction permettant de récupérer l'id maximal des cards
  public static function get_card_max_id()
  {
    $db = Db::initDB();
    $maxId = $db->query('SELECT MAX(id) AS MaxIdNumber FROM card');
    $maxId->execute();
    return $maxId->fetchColumn();
  }
}
