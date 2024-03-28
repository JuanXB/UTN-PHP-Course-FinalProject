<?php

class Date {

    /**
     * Retorna la fecha actual
     */
    public static function now() : string|false 
    {
        // Setea la zona horaria 
        date_default_timezone_set(APP_CONFIG['timeZone'] ?? 'America/Argentina/Buenos_Aires');
        return date("Y-m-d H:i:s");
    }
}