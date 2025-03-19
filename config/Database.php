<?php
class Database {
    private $host = 'localhost';
    private $usuario = 'root';  // Cambia por tu usuario de MySQL
    private $password = '2002'; // Cambia por tu contraseña
    private $database = 'wemakerssystem'; // Cambia por el nombre de tu base de datos
    private $conn;
    
    /**
     * Constructor que establece la conexión con la base de datos
     */
    public function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->usuario, $this->password, $this->database);
            
            if ($this->conn->connect_error) {
                throw new Exception("Error de conexión: " . $this->conn->connect_error);
            }
            
            // Establecer charset a utf8
            $this->conn->set_charset("utf8");
            
        } catch (Exception $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
    
    /**
     * Obtener la conexión a la base de datos
     * @return mysqli Objeto de conexión
     */
    public function getConnection() {
        return $this->conn;
    }
    
    /**
     * Preparar una consulta SQL
     * @param string $query Consulta SQL con placeholders
     * @return mysqli_stmt Declaración preparada
     */
    public function prepare($query) {
        return $this->conn->prepare($query);
    }
    
    /**
     * Cerrar la conexión a la base de datos
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>