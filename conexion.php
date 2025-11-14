<?php

/**

 * Clase de Conexión a Base de Datos

 * Base de datos: phpmyadmin

 */

 

class Conexion {

    // Propiedades de configuración

    private $host = 'localhost';

    private $dbname = 'phpmyadmin';

    private $username = 'root';

    private $password = '';

    private $charset = 'utf8mb4';

    private $conexion;

 

    /**

     * Constructor - Establece la conexión automáticamente

     */

    public function __construct() {

        $this->conectar();

    }

 

    /**

     * Método para conectar a la base de datos

     * @return PDO

     */

    private function conectar() {

        try {

            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

            $opciones = [

                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,

                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                PDO::ATTR_EMULATE_PREPARES   => false,

            ];

 

            $this->conexion = new PDO($dsn, $this->username, $this->password, $opciones);

            return $this->conexion;

        } catch (PDOException $e) {

            error_log("Error de conexión a la base de datos: " . $e->getMessage());

            die("Error de conexión a la base de datos. Por favor, intente más tarde.");

        }

    }

 

    /**

     * Obtener la conexión PDO

     * @return PDO

     */

    public function getConexion() {

        return $this->conexion;

    }

 

    /**

     * Cerrar la conexión

     */

    public function cerrar() {

        $this->conexion = null;

    }

 

    /**

     * Iniciar transacción

     */

    public function iniciarTransaccion() {

        return $this->conexion->beginTransaction();

    }

 

    /**

     * Confirmar transacción

     */

    public function confirmarTransaccion() {

        return $this->conexion->commit();

    }

 

    /**

     * Revertir transacción

     */

    public function revertirTransaccion() {

        return $this->conexion->rollBack();

    }

 

    /**

     * Preparar una consulta SQL

     * @param string $sql

     * @return PDOStatement

     */

    public function preparar($sql) {

        return $this->conexion->prepare($sql);

    }

 

    /**

     * Obtener el último ID insertado

     * @return string

     */

    public function obtenerUltimoId() {

        return $this->conexion->lastInsertId();

    }

 

    /**

     * Ejecutar una consulta directa

     * @param string $sql

     * @return PDOStatement

     */

    public function ejecutar($sql) {

        return $this->conexion->query($sql);

    }

}

?>

 