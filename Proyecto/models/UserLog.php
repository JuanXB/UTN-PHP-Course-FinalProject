<?php

include_once 'database/Conexion.php';

class UserLog
{   
    //Nombre de la tabla a la que hace referencia el modelo
    const TABLE_NAME = 'users_logs';
    //Nombre de la tabla con la que el modelo esta relacionado
    // mediante un foreing key
    const TABLE_NAME_RELATION = 'users';

  
    /**
     *  Crea un nuevo user log del usuario 
     *  al que corresponda el userId.
     */
    public static function create($userId, string $action)
    {

        try {
            $conexion = new Conexion();
            
            $stmt = $conexion->connect()->prepare("INSERT INTO " . self::TABLE_NAME . "(user_id, action)
                    VALUES (:user_id, :action)");
            $stmt->execute(array(
                ':user_id' => $userId, ':action' => $action
            ));
        } catch (PDOException $e) {
            throw new PDOException("[UserLog - create ] PDO Error ".$e->getMessage());
        } catch (Exception $e) {
            throw new Exception("[UserLog - create ] Error ".$e->getMessage());
        } finally {
            $conexion->close();
            $stmt = null;
        }
    }

    /**
     * Obtiene  los ultimos 30 logs relacionados 
     * al user id. 
     */
    public static function all($userId, $limit = 30)
    {

        try {
            $conexion = new Conexion();
            //Se seleciona todos los user logs asociados al user_id
            // y mediante la relacion con la tabla user mediante 
            // una foregin key se obtiene el nombre del usuario de la tabla users
            // mediante un join de tablas
            $stmt = $conexion->connect()->query("SELECT ul.* , u.name FROM " . self::TABLE_NAME . " ul JOIN ".self::TABLE_NAME_RELATION.
                " u ON ul.user_id = u.id WHERE ul.user_id = {$userId} ORDER BY created_at DESC LIMIT " . $limit);
            $users = $stmt->fetchAll();

            return $users;
        } catch (PDOException $e) {
            throw new PDOException("[UserLog - all ] PDO Error ".$e->getMessage());
        } catch (Exception $e) {
            throw new Exception("[UserLog - all ] Error ".$e->getMessage());
        } finally {
            $conexion->close();
            $stmt = null;
        }
    }
}
