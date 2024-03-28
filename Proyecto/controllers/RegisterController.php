<?php
include_once 'models/User.php';
include_once 'models/UserLog.php';
include_once 'models/Session.php';
include_once 'controllers/ValidatorController.php';


class RegisterController
{

    /**
     * Carga el nuevo usuario en la DB,
     * crea un user log de que fue creado,
     * crea la session del usuario,
     * y cambia el estado del mismo a conectado
     */
    public static function registerUser(string $name, string $email, string $password)
    {

        // Se validan los parametros antes de consultar la DB
        $validName = ValidatorController::validateName($name);

        if (!$validName['success']) {
            return $validName;
        }

        // Se corrobora que el user name no este en uso ya que debe ser unico
        if (User::nameExist($name)) {
            return [
                'success' => false,
                'message' => 'El nombre de usuario ya esta en uso',
                'param' => 'name',
            ];
        }

        $validEmail = ValidatorController::validateEmail($email);

        if (!$validEmail['success']) {
            return $validEmail;
        }

        $validPass = ValidatorController::validatePassword($password);

        if (!$validPass['success']) {
            return $validPass;
        }


        try {
            // Se crea un nuevo usuario y se inicializa con el estado connected en true
            $newUser = User::create($name, $email, $password, true);

            // Se hace un log asociado al user de que fue creado
            UserLog::create($newUser['id'], 'Se creo un nuevo usuario');

            // Se crea la session
            Session::loginSession($newUser['id']);

            // Se redirije al usuario a la tabla con los ultimos usuarios actualizados
            http_response_code(200);
            return ['success' => true, 'redirect' => 'index.php?route=users'];
        } catch (\Exception $e) {
            ErrorLog::saveLog("[RegisterController - registerUser] " . $e->getMessage());

            http_response_code(500);
            return ['success' => false, 'redirect' => 'index.php?route=500'];
        }
    }
}
