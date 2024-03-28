<?php
include_once 'models/ErrorLog.php';

class Validation
{
    /**
     * Corrobora que el parametro no este vacio
     */
    public static function isEmpty($param) : bool
    {
        return empty($param);
    }

    /**
     * Corrobora que el email recibido sea valido
     */
    public static function validEmail($email) : bool
    {   
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Hace un regex con un min y max para corroborar que el parametro 
     * tenga la longitud que se requiere
     */
    public static function minAndMaxLeng(string $param, int $min, int $max): bool
    {
        $regex = "/^.{{$min},{$max}}$/";

        return preg_match($regex, $param);
    }

    /**
     * Corrobora que el parametro name no contenga 
     * espacios en blanco ni caracteres especiales
     */
    public static function validName(string $name): bool
    {
        $regex =  '/^[a-zA-Z0-9]+$/';

        return preg_match($regex, $name);
    }

    
   
}
