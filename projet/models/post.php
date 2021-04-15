<?php
  class Post {
    // we define 3 attributes
    // they are public so that we can access them using $post->date directly
    public $id;
    public $date;
    public $content;
    public $shots;

    public function __construct($id, $date, $content, $shots) {
      $this->id      = $id;
      $this->date  = $date;
      $this->content = $content;
      $this->shots = $shots;
    }

    public static function all() {
      $list = [];
      $db = Db::initDB();
      $req = $db->query('SELECT * FROM card');

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
        $list[] = new Post($post['id'], $post['date'], $post['content'], $post['shots']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::initDB();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM card WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
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
    
  }
