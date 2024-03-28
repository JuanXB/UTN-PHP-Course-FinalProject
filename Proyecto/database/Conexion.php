<?php

class Conexion
{

    private string $dsn;
    private string $user;
    private string $password;
    private string $charset;
    public $db = null;

    /**
     * Obtiene los datos para crear la conexion.
     */
    public function __construct()
    {   
        // Obtiene los datos relacionados a la DB para crear la conexion.
        try {
            $this->dsn = "mysql:host=" . DB_CONFIG["host"] . ";dbname=" . DB_CONFIG["dbname"];
            $this->user = DB_CONFIG['user'];
            $this->password = DB_CONFIG['password'];
            $this->charset = DB_CONFIG['charset'];
        } catch (Exception $e) {
            throw new Exception("[Conexion - construct ] Error ".$e->getMessage());    
        }
    }

    /**
     * Crea y retorna la conexion con la DB usando PDO
     * 
     */
    public function connect() 
    {
        try {
            // Conectar
            $this->db = new PDO($this->dsn, $this->user, $this->password);
            // Establecer el nivel de errores a EXCEPTION
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->db->exec("set names ".$this->charset);

            return $this->db;
        } catch (PDOException $e) {
            $this->close();
            throw new PDOException("[Conexion - construct ] PDO Error ".$e->getMessage());    
        }
        catch (Exception $e) {
            $this->close();
            throw new Exception("[Conexion - construct ]  Error ".$e->getMessage());    
        } 
    }

    /**
     * Cierra la conexion
     */
    public function close()
    {
        $this->db = null;
    }
}
