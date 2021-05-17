<?php
class Post
{
  // we define 3 attributes
  // they are public so that we can access them using $post->date directly
  public $id;
  public $date;
  public $content;
  public $shots;

  public function __construct($id, $date, $content, $shots)
  {
    $this->id      = $id;
    $this->date  = $date;
    $this->content = $content;
    $this->shots = $shots;
  }

  public static function all()
  {
    $list = [];
    $db = Db::initDB();
    $req = $db->query('SELECT * FROM card');

    // we create a list of Post objects from the database results
    foreach ($req->fetchAll() as $post) {
      $list[] = new Post($post['id'], $post['date'], $post['content'], $post['shots']);
    }

    return $list;
  }

  public static function find($id)
  {
    $db = Db::initDB();
    // we make sure $id is an integer
    $id = intval($id);
    $req = $db->prepare('SELECT * FROM card WHERE id = :uid');
    // the query was prepared, now we replace :id with our actual $id value
    $req->execute(array(':uid' => $id));
    $post = $req->fetch();

    return new Post($post['id'], $post['date'], $post['content'], $post['shots']);
  }

  static function number_of_cards()
  {
    $db = Db::initDB();
    $number_of_cards = $db->query('SELECT COUNT(*) FROM card');
    $number_of_cards->execute();
    return $number_of_cards->fetchColumn();
  }

  public static function addCard($content, $shots, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('INSERT INTO card (date, content, shots) VALUES (now(),:ucontent,:ushots);');

    // the query was prepared, now we replace :id with our actual $id value
    if ($req->execute(array(':ucontent' => $content, ':ushots' => $shots))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }

  public static function deleteCard($id, $urlTo)
  {
    $db = Db::initDB();
    $req = $db->prepare('DELETE FROM card WHERE id = :uid');

    // the query was prepared, now we replace :id with our actual $id value
    if ($req->execute(array(':uid' => $id))) {
      functions_controller::redirect($urlTo);
      return 1;
    }
    return 0;
  }

  public static function get_card_min_id()
  {

    $db = Db::initDB();
    $minId = $db->query('SELECT MIN(id) AS MinIdNumber FROM card');
    $minId->execute();
    return $minId->fetchColumn();
  }

  public static function get_card_max_id()
  {

    $db = Db::initDB();
    $maxId = $db->query('SELECT MAX(id) AS MaxIdNumber FROM card');
    $maxId->execute();
    return $maxId->fetchColumn();
  }
}
