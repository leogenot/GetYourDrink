<?php

function dbConnect()
{
    try {
        $bdd = new PDO(
            'mysql:host=localhost;dbname=sys_likes;charset=utf8','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $bdd;
    } catch (PDOException $exception) {
        die('Erreur : ' . $exception->getMessage());
    }
}
