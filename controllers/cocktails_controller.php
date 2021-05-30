<?php

  class cocktails_controller {
    public function index() {
      // we store all the cocktails in a variable
      $cocktails = Cocktails::all();
      $alcools = Alcool::all();
      $diluants = Diluant::all();
      require_once('views/cocktails/index_cocktails.php');
    }

    public function remove() {
      // we expect a url of form ?controller=cocktails&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $cocktail = Cocktails::deleteCocktails($_GET['id'], "/alcoolimac/projet/");
      require_once('views/cocktails/index_cocktails.php');
    }

  }

?>