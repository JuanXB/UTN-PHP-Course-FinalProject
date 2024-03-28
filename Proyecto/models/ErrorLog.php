<?php
include_once 'models/Date.php';

class ErrorLog
{
    const PATH = "errors.log";

    /**
     * Guarda el mensaje de error en el archivo errors.log
     */
    public static function saveLog(string $message): void
    {
        // Abre o crea el archivo en modo de escritura
        $archivo = fopen(self::PATH, "a");
        $currentDate = Date::now();
        if ($archivo) {
            // Formatea el mensaje de error con la fecha y hora actual
            $log = "[" . $currentDate . "] " . $message . "\n";

            fwrite($archivo, $log);

            fclose($archivo);

        } else {
            echo "No se pudo abrir el archivo de registro para escribir el mensaje de error.";
        }
    }
}
