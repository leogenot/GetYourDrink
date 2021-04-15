<?php
class FunctionsDb extends Db
{

    static function create_querySelect($criterias, $operators, $conditions = null)
    {
        $query = '';
        $fields_conditions_keys = FunctionsDb::getTableColums($criterias);
        $fields_conditions_question = FunctionsDb::getPrepareNumbersFields($criterias);
        $operators_count = count($operators);
        $operators_value = FunctionsDb::getTableValues($operators);
        $length = count($criterias);
        if (!is_null($conditions)) {
            if (in_array(strtoupper($conditions), array('OR', 'AND',))) {
                for ($i = 0; $i < $length - 1; $i++) {
                    if ($operators_count == 1)
                        $query .= $fields_conditions_keys[$i] . ' ' . $operators_value[0] . ' ' . $fields_conditions_question[$i] . ' ' . strtoupper($conditions) . ' ';
                    else
                        $query .= $fields_conditions_keys[$i] . ' ' . $operators_value[$i] . ' ' . $fields_conditions_question[$i] . ' ' . strtoupper($conditions) . ' ';
                }
                $query .= $fields_conditions_keys[$length - 1] . ' ' . $operators_value[$operators_count - 1] . ' ' . $fields_conditions_question[$length - 1];
            } else
                throw new Exception("Argument invalid : accepted paramaters => and, or");
        } else
            $query .= $fields_conditions_keys[$length - 1] . ' ' . $operators_value[0] . ' ' . $fields_conditions_question[$length - 1];
        return $query;
    }

    static function getPrepareNumbersFields($data)
    {
        $numberFields = count($data);
        return explode(',', str_repeat("?,", $numberFields - 1) . "?");
    }
    static function getTableColums(array $data)
    {
        if (empty($data))
            throw new Exception("Vous n'avez pas fournis les noms des champs de la table");
        $colums = [];
        foreach ($data as $colum => $value) {
            $colums[] = $colum . ' ';
        }
        return $colums;
    }


    static function getTableValues(array $data)
    {
        if (empty($data))
            throw new Exception("Vous n'avez pas fournis les valeurs des champs de la table");
        $values = [];
        foreach ($data as $colum => $value) {
            $values[] = $value . ' ';
        }
        return $values;
    }
    /**
     * Permet de rechercher un like à travers son utilisateur et la card

     */
    static function findBy(array $tables, $field, $condition)
    {
        $db = Db::initDB();
        $query = 'SELECT ' . $field . ' FROM ' . implode(',', $tables) . ' WHERE ' . $condition;
        $request = $db->query($query);
        $response = $request->fetch(PDO::FETCH_OBJ);
        return (null != $response) ? $response : null;
    }
    /**
     * Supprime une donnée ou des données dans la base de données suivant les conditions
     * exemple: delete('user',array(
     * 'age => 10,
     *  'sexe' => 'masculin'
     * ),'
     * array('<','='),
     * or');
     */
    static function delete($table_name, $criterias, $operators, $condition = null)
    {
        $db = Db::initDB();
        $query = 'DELETE FROM ' . $table_name . ' WHERE ' . FunctionsDb::create_querySelect($criterias, $operators, $condition);
        echo $query;
        $requette = $db->prepare($query);
        $nblignes = $requette->execute(FunctionsDb::getTableValues($criterias));
        return $nblignes;
    }

    /**
     * exemple: insertInTo('user',
     *    array('name' => 'name',
     *          'email' => 'email@email.com',
     *          'username' => 'username'))

     */
    static function insertInTo($table_name, array $data)
    {
        $db = Db::initDB();
        $query = 'INSERT INTO ' . $table_name . ' (' . implode(',', FunctionsDb::getTableColums($data)) . ') VALUES (' . implode(',', FunctionsDb::getPrepareNumbersFields($data)) . ')';
        $requette = $db->prepare($query);
        $nbline_affected = $requette->execute(FunctionsDb::getTableValues($data));
        return $nbline_affected;
    }
}
