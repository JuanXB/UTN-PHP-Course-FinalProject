<?php
include_once 'controllers/RegisterController.php';
include_once 'controllers/LoginController.php';
include_once 'controllers/UserController.php';
include_once 'models/Session.php';
include_once 'models/ErrorLog.php';


class RouteController
{

    /**
     * Administra que metodo llamar segun que metodo
     * de request se recibio
     */
    public static function handleRequest()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                self::handlePostRequest();
                return;
            case "GET":
                self::handleGetRequest();
                return;
        }
        http_response_code(405); // Método no permitido
        header('Location:views/errors/500.php');

    }

    /**
     * Administra las vistas que usan el metodo GET.
     */
    public static function handleGetRequest(): void
    {
        $route = isset($_GET['route']) ? $_GET['route'] : false;

        // Las rutas login y register solo son accesibles si el usuario no tiene
        // una session activa
        if (!Session::hasSessionLogin()) {
            switch ($route) {
                case 'register':
                    include_once APP_CONFIG['viewsPath'] . "/register.php";;
                    return;
                case 'login':
                    include_once APP_CONFIG['viewsPath'] . "/login.php";
                    return;

                default:
                    include_once APP_CONFIG['viewsPath'] . "/login.php";
                    return;
            }
        }

        include_once APP_CONFIG['viewsPath'] . '/layout.php';
    }

    /**
     * Administra las vistas que usan el metodo POST.
     */
    public static function handlePostRequest()
    {
        // Llamar al método correspondiente según el valor de "action"
        if (isset($_POST['action'])) {
            // Se hace un echo json_encode de las respuestas de los 
            // controladores para que sean captados mediante AJAX
            
            switch ($_POST['action']) {
                case 'register':
                    echo json_encode(RegisterController::registerUser(
                        self::checkParamIsSet($_POST["name"]),
                        self::checkParamIsSet($_POST["email"]),
                        self::checkParamIsSet($_POST["password"])
                    ));
                    return;
                case 'login':
                    echo json_encode(LoginController::login(
                        self::checkParamIsSet($_POST["name"]),
                        self::checkParamIsSet($_POST["password"])
                    ));
                    return;
                case 'delete':
                    echo json_encode(UserController::delete());
                    return;
                case 'logout':
                    echo json_encode(LoginController::logout());
                    return;
                default:
                    header('Location:index.php?route=404');
                    return;
            }
        }

        echo json_encode(['success' => false, 'redirect' => 'index.php?route=login']);
        return;
    }

    /**
     * Si el parametro no esta seteado retorna null.
     */
    private static function checkParamIsSet($param)
    {
        return isset($param) ? $param :  null;
    }
}
