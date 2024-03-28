<?php

class Session
{   
    /**
     * Guarda datos en la session
     */
    public static function loginSession($userId): void
    {
        $_SESSION["login"] = "ok";
        $_SESSION["user_id"] = $userId;
       
    }

    /**
     * Controla que los parametros de la session del usuario existan
     */
    public static function hasSessionLogin(): bool
    {
        return isset($_SESSION["login"]) && ($_SESSION["login"] == "ok");
    }

    /**
     * Destruye la session
     */
    public static function closeSession() : void 
    {
        session_destroy();
    }
}
