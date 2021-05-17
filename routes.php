<?php
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
    }

    $controller->{ $action }();
  }

  // we're adding an entry for the new controller and its actions
  $controllers = array('pages' => ['login', 'register', 'home', 'error'],
                       'posts' => ['index', 'show', 'remove']);

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