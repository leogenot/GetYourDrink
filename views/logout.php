<?php

require($_SERVER['DOCUMENT_ROOT'] . "/alcoolimac/projet/require.php");

// Lorsque cette page est appelée, la fonction logout est déclenchée
user_controller::logout("/alcoolimac/projet/views/pages/connexionView.php");