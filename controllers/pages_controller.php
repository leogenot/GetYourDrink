<?php
  class pages_controller {

    public function login() {
      require_once('views/pages/connexionView.php');
    }

    public function register() {
      require_once('views/pages/registerView.php');
    }

    public function home() {
      $first_name = $_SESSION['username'];
      require_once('views/pages/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>