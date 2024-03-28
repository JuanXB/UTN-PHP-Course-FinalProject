<?php
include_once 'models/Session.php';
include_once 'models/User.php';
include_once 'models/ErrorLog.php';
include_once 'controllers/ValidatorController.php';



class LoginController
{

    /**
     * Valida los datos de login del usuario,
     * si son validados hace una consulta a la DB
     * para verificar si el usuario esta registrado.
     */
    public static function login(?string $name, ?string $password)
    {
        // Se hace una validaicon de campos antes de hacer consultas en al DB.
        
        $validName = ValidatorController::validateName($name);

        if (!$validName['success']) {
            return $validName;
        }

        $validPass = ValidatorController::validatePassword($password);

        if (!$validPass['success']) {
            return $validPass;
        }

        try {

            // Se busca al usuario por nombre en la DB
            $user = User::getByField($name, 'name');

            if (!$user) {
                http_response_code(200);
                return [
                    'success' => false,
                    'message' => 'No existe el nombre de usuario',
                    'param' => 'name',
                ];
            }

            // Se verifica que la contrseña recibida coincida con la de la DB
            if (!password_verify($password, $user['password'])) {
                http_response_code(200);
                return [
                    'success' => false,
                    'message' => 'Contraseña incorrecta',
                    'param' => 'password',
                ];
            }

            // Se crea un log asociado al usuario de que se logueo
            UserLog::create($user['id'], 'Ingreso al sitio');
            // Cambia su estado a conectado en la DB
            User::update($user['id'], 1, 'connected');
            // Crea la sesion del usuario con su id
            Session::loginSession($user['id']);

            http_response_code(200);
            return ['success' => true, 'redirect' => 'index.php?route=users'];
            
        } catch (\Exception $e) {
            ErrorLog::saveLog("[LoginController - login] " . $e->getMessage());

            http_response_code(500);
            return ['success' => false, 'redirect' => 'index.php?route=500'];
        }
    }

    /**
     * Crear un log de usuario para registrar la cerrada se sesion,
     * Cambia el estado de connected a false del usuario  y
     * destruye la sesion.
     */
    public static function logOut()
    {
        // Obtiene el user id de la session
        $userId = $_SESSION['user_id'];

        try {
            // Se crea un log asociado al usuario para registrar que cerro la session
            UserLog::create($userId, 'El usuario cerro sesion');

            // Al cerrar la session el valor de connected del usuario en la DB
            // pasa a false (0)
            User::update($userId, 0, 'connected');

            // Se destruye la session relacionada al usuario
            Session::closeSession();

            http_response_code(200);
            return ['success' => true, 'redirect' => 'index.php?route=login'];

        } catch (\Exception $e) {
            ErrorLog::saveLog("[LoginController - logOut] " . $e->getMessage());

            http_response_code(500);
            return ['success' => false, 'redirect' => 'index.php?route=500'];
        }
    }
}
