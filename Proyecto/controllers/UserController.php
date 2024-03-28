<?php
include_once 'models/User.php';

class UserController
{

    /**
     * Llama al mdoelo User para obtener los
     * primeros 50 usuarios.
     */
    public static function getUsers()
    {
        try {

            return User::all();
        } catch (\Exception $e) {
            ErrorLog::saveLog("[UserController - getUsers] " . $e->getMessage());

            header('Location:views/errors/500.php');
        }
    }

    /**
     * Obtiene el usuario mediante el id de sesion
     */
    public static function getUserById()
    {
        try {

            return User::getByField($_SESSION['user_id'], 'id');
        } catch (\Exception $e) {
            ErrorLog::saveLog("[UserController - getUserById] " . $e->getMessage());

            http_response_code(500);
            header('Location:views/errors/500.php');
        }
    }

    /**
     * Elimina un usuario
     */
    public static function delete()
    {
        $userId = $_SESSION['user_id'];
        try {
    
            User::delete($userId);

            // Se elimina la session
            Session::closeSession();

            return ['success' => true, 'redirect' => 'index.php?route=login',
            'message' => 'Se elimino el usuario'];

        } catch (\Exception $e) {
            ErrorLog::saveLog("[UserController - getUserById] " . $e->getMessage());

            http_response_code(500);

            return ['success' => false, 'redirect' => 'index.php?route=500'];

        }
    }

    /**
     * Edita el usuario
     */
    public static function edit(?string $name, ?string $email)
    {
        $userId = $_SESSION['user_id'];
     
        try {
            $validEmail = ValidatorController::validateEmail($email);

            if (!$validEmail['success']) {
                return $validEmail;
            }
            
            $validName = ValidatorController::validateName($name);
    
            if (!$validName['success']) {
                return $validName;
            }

            if (User::nameExist($name, $userId)) {
                return [
                    'success' => false,
                    'message' => 'El nombre de usuario ya esta en uso',
                    'param' => 'name',
                ];
            }

            $user = User::getByField($userId, 'id');

            self::updateEmail($email, $user['email'], $userId);
            self::updateName($name, $user['name'], $userId);

            return ['success' => true, 'redirect' => 'index.php?route=profile'];

        } catch (\Exception $e) {
            ErrorLog::saveLog("[UserController - getUserById] " . $e->getMessage());

            http_response_code(500);

            return ['success' => false, 'redirect' => 'index.php?route=500'];

        }
    }

    private static function updateEmail(?string $newEmail, string $oldEmail, $userId): void
    {
        try {
            if ((!empty($newEmail)) && $newEmail != $oldEmail) {
                User::update($userId, $newEmail, 'email');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private static function updateName(?string $newName, string $oldName, $userId): void
    {
        try {
            if ((!empty($newName)) && $newName != $oldName) {
                User::update($userId, $newName, 'name');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
