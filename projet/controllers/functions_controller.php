<?php

class FunctionsController
{
    static function redirect($urlTo)
    {

        header('Location:' . $urlTo);
    }

    /**
     * HtmlSpecialChar

     */
    static function purge($form_field)
    {
        return htmlspecialchars($form_field);
    }
}
