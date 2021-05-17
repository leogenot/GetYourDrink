<?php

class Likes
{
    /**
     * Liker un card à partir de son id et celui de l'utilisateur

     */
    static function likes_cards_by_id($card_id)
    {
        $error = null;
        //verifier si cet card à deja un like de cet utilisateur, si oui on le retire
        $likes_data = FunctionsDb::findBy(['likes'], 'COUNT(id) as is_like, id as id_like', 'likes.user_id = ' . user_controller::get_session('user_id') . ' AND likes.card_id = ' . $card_id);
        if (!is_null($likes_data) && $likes_data->is_like == 1) {
            try {
                Likes::remove_like_by_id($likes_data->id_like);
            } catch (Exception $exception) {
                die('Erreur : ' . $exception->getMessage());
                $error = 'Une erreur interne est survenue lors de la suppresion du like ';
            }
        } else {
            //Sinon on ajoute le like
            try {
                Likes::add_like($card_id);
            } catch (Exception $exception) {
                die('Erreur : ' . $exception->getMessage());
                $error = 'Une erreur est survenue lors du like ';
            }
        }
        return $error;
    }
    /**
     * Supprimer un like attribuer à une card

     */
    static function remove_like_by_id($like_id)
    {
        FunctionsDb::delete('likes', ['id' => $like_id], ['=']);
    }

    /**
     * Ajoute le like à la card

     */
    static function add_like($card_id)
    {
        FunctionsDb::insertInTo('likes', [
            'card_id' => $card_id,
            'user_id' => user_controller::get_session('user_id')
        ]);
    }
    static function count_all_likes_by_card_id($card_id)
    {
        $likes = FunctionsDb::findBy(['likes'], 'COUNT(id) as nb_likes', 'likes.card_id = ' . $card_id);
        if (!is_null($likes) && $likes->nb_likes > 0)
            return $likes->nb_likes;
        return 0;
    }
}
