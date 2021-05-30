<?php
  class diluant_controller {
    public function index() {
      // we store all the cocktails in a variable
      $diluants= Diluant::all();
      require_once('views/diluant/index_diluant.php');

    }

    public function remove() {
      // we expect a url of form ?controller=cocktails&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $diluant = Diluant::deleteDiluant($_GET['id'], "/alcoolimac/projet/");
      //require_once('views/alcool/index_alcool.php');
    }

  }

?>