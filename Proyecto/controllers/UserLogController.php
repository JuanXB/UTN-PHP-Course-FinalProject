<?php
include_once 'models/UserLog.php';

class UserLogController {

    /**
     * Obtiene los ultimos 30 log del usuario.
     */
    public static function getAllUserLogs() {
        try {
           return UserLog::all($_SESSION['user_id']);
        } catch (\Exception $e) {
            ErrorLog::saveLog("[UserLogController - getAllUserLogs] ".$e->getMessage());
            
            http_response_code(500);
            header('Location:views/errors/500.php');
        }
    }
}