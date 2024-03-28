<?php

include_once 'database/Conexion.php';
include_once 'models/Date.php';

class User
{
    const TABLE_NAME = 'users';

    /**
     * Crear un usuario nuevo en la tabla users y lo retorna.
     */
    public static function create(string $name, string $email, string $password, bool $connected)
    {

        try {
            $conexion = new Conexion();

            //Se hace un hash de las contraseña para almacenarla en la Db
            $hash = self::hashPassword($password);

            // Se crea el nuevo usuario
            $stmt = $conexion->connect()->prepare("INSERT INTO " . self::TABLE_NAME . "(name, email, password, connected)
                    VALUES (:name, :email, :password, :connected)");
            $userCreate = $stmt->execute(array(
                ':name' => $name,
                ':email' => $email,
                ':password' => $hash,
                ':connected' => $connected
            ));

            if ($userCreate) {
                // Se obtiene el nuevo user creado y se retorna
                $stmt = $conexion->connect()->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE name = :name ORDER BY created_at DESC LIMIT 1");
                $stmt->bindParam(':name', $name);
                $getNewUser = $stmt->execute();
                if ($getNewUser) {
                    $newUser = $stmt->fetch();
                    return $newUser;
                } else {
                    echo $conexion->connect()->errorInfo();
                }
            }
        } catch (PDOException $e) {
            throw new PDOException("[User - create ] PDO Error " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("[User - create ] Error " . $e->getMessage());
        } finally {
            $conexion->close();
            $stmt = null;
        }
    }

    /**
     * Obtiene los ultimos 50 usuarios creados.
     */
    public static function all(int $limit = 50)
    {

        try {
            $conexion = new Conexion();
            // Se obtienem los ultimos usuarios que han tenido un update en la DB 
            $stmt = $conexion->connect()
                ->query("SELECT `name`, `email`, `connected`, `created_at`, `updated_at` 
                FROM " . self::TABLE_NAME . " 
                ORDER BY updated_at DESC LIMIT " . $limit);

            $users = $stmt->fetchAll();

            return $users;
        } catch (PDOException $e) {
            throw new PDOException("[User - all ] PDO Error " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("[User - all ] Error " . $e->getMessage());
        } finally {
            $conexion->close();
            $stmt = null;
        }
    }

    /**
     * Obtiene el ultimo registro que se agrego de la tabla users
     * dependiendo el valor y el campo que se le pase.
     */
    public static function getByField(string $value, string $field)
    {
        try {
            // Obtiene el ultimo usuario que se agrego que cumpla con la 
            // clausula WHERE
            $conexion = new Conexion();
            $stmt = $conexion->connect()->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE {$field} = :{$field} ORDER BY created_at DESC LIMIT 1");
            $stmt->bindParam(":{$field}", $value);
            $stmt->execute();
            $newUser = $stmt->fetch();

            return $newUser;
        } catch (PDOException $e) {
            throw new PDOException("[User - getByField] PDO Error " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("[User - getByField ] Error " . $e->getMessage());
        } finally {
            $conexion->close();
            $stmt = null;
        }
    }

    /**
     * Updatea un campo del usuario al que perteneces el user id
     */
    public static function update($userId, $value, string $field)
    {
        try {
            $conexion = new Conexion();

            // Obtiene la fecha actual
            $currenDate = Date::now();

            // Hace un update de un campo perteneciente al user_id que se recibe como parametro
            $stmt = $conexion->connect()->prepare("UPDATE " . self::TABLE_NAME . " SET {$field} = :value , updated_at = :now WHERE id = :userId");
            $stmt->bindParam(":value", $value);
            $stmt->bindParam(":userId", $userId);
            $stmt->bindParam(":now", $currenDate);

            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException("[User - update ] PDO Error " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("[User - update ] Error " . $e->getMessage());
        } finally {
            $conexion->close();
            $stmt = null;
        }
    }

    public static function delete($userId): void
    {

        try {
            $conexion = new Conexion();
            // Elimina el usuario al que pertenece el user id
            $stmt = $conexion->connect()->prepare("DELETE FROM " . self::TABLE_NAME . " WHERE id = :userId");
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();
            
        } catch (PDOException $e) {
            throw new PDOException("[User - update ] PDO Error " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("[User - update ] Error " . $e->getMessage());
        } finally {
            $conexion->close();
            $stmt = null;
        }
    }

    /**
     * Verifica si el name ya existe en la DB ya que debe ser unico
     */
    public static function nameExist(string $name, $userId = null): bool
    {
        try {
            // Se corrobora si el $userId no viene en null para agregar el parametro
            // a la consulta
            $excludeUser =  is_null($userId) ? "" : "AND id != :user_id";
            $conexion = new Conexion();
            // El SELECT 1 hace la consulta mas optima
            $stmt = $conexion->connect()->prepare("SELECT 1 FROM " . self::TABLE_NAME . " WHERE name = :name {$excludeUser}  LIMIT 1");
            $stmt->bindParam(':name', $name);

            // Se corrobora si el $userId no viene en null para agregar el parametro
            // a la consulta antes de ejecutarla
            if (!is_null($userId)) {
                $stmt->bindParam(':user_id', $userId);
            }

            $stmt->execute();

            // Verificar si se obtuvo algún resultado
            if ($stmt->fetchColumn()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            throw new PDOException("[User - update ] PDO Error " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("[User - update ] Error " . $e->getMessage());
        } finally {
            $conexion->close();
            $stmt = null;
        }
    }

    /**
     * Encripta la contraseña del usuario antes de almacenarla en la DB.
     */
    private static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
