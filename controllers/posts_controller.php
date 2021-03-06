<?php
  class posts_controller {
    public function index() {
      // we store all the posts in a variable
      $posts = Post::all();
      require_once('views/posts/index_post.php');
    }

    public function show() {
      // we expect a url of form ?controller=posts&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $post = Post::find($_GET['id']);
      require_once('views/posts/show_post.php');
    }

    public function showRandom() {
      $post = Post::findRandom();
      require_once('views/posts/show_post.php');
    }

    public function remove() {
      // we expect a url of form ?controller=posts&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $post = Post::deleteCard($_GET['id'], "/alcoolimac/projet/");
      require_once('views/posts/show_post.php');
    }

  }

?>