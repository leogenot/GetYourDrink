<?php

class functions_controller
{

    static function echoHello(){

        echo "ca marche pas la frerot";
    }
    
    static function redirect($urlTo)
    {

        echo "
            <script type=\"text/javascript\">
            var url = '".$urlTo."'

            window.location.replace(url);
            </script>
        ";
    }

    /**
     * HtmlSpecialChar

     */
    static function purge($form_field)
    {
        return htmlspecialchars($form_field);
    }
}
