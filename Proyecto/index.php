<?php
// Se incluyen los archivos con los datos
// de configuracion del proyecto
include_once 'config/app.php';
include_once 'config/database.php';

// Activa o desactiva los errores segun este seteado en la config de la app
ini_set('display_errors', APP_CONFIG['display_error']);
error_reporting(E_ALL);

// Inicia la session
session_start();

// LLama al Route controller para que administre las request
include_once 'controllers/RouteController.php';

RouteController::handleRequest();

