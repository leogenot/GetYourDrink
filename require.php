  
<?php

// Grâce à cette page, toutes les pages seront liées les unes 
// aux autres et on aura pas de problèmes liés à l'inclusion


    //Require controllers
    require_once "controllers/functions_controller.php";
    require_once "controllers/pages_controller.php";
    require_once "controllers/posts_controller.php";
    require_once "controllers/alcool_controller.php";
    require_once "controllers/cocktails_controller.php";
    require_once "controllers/diluant_controller.php";
    require_once "controllers/user_controller.php";
    require_once "controllers/tempuser_controller.php";

    
    
    //Require configs
    require_once "models/Db.php";
    require_once "models/FunctionsDb.php";
    require_once "models/Likes.php";
    require_once "models/Post.php";
    require_once "models/Alcool.php";
    require_once "models/Cocktails.php";
    require_once "models/Diluant.php";
    require_once "models/UserModel.php";
    require_once "models/TempUserModel.php";

    

