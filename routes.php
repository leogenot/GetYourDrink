<?php
// on renvoit chaque endpoint à la fonction qu'il doit appeler selon différents cas
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        $controller = new pages_controller();
      break;
      case 'posts':
        // we need the model to query the database later in the controller
        require_once('models/Post.php');
        $controller = new posts_controller();
      break;
      
      case 'alcool':
        // we need the model to query the database later in the controller
        require_once('models/Alcool.php');
        $controller = new alcool_controller();
      break;
      case 'diluant':
        // we need the model to query the database later in the controller
        require_once('models/Diluant.php');
        $controller = new diluant_controller();
      break;
      case 'cocktails':
        // we need the model to query the database later in the controller
        require_once('models/Cocktails.php');
        $controller = new cocktails_controller();
      break;
    }

    $controller->{ $action }();
  }
  
  // on ajoute au nouveau controller chacune de ses actions
  $controllers = array('pages' => ['login', 'register', 'home', 'error'],
                       'posts' => ['index', 'show','showRandom', 'remove'],
                      'alcool'=> ['index', 'remove'],
                      'diluant' => ['index', 'remove'],
                      'cocktails' => ['index', 'remove']);

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>