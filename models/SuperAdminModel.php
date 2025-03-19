<?php
class SuperAdminModel {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Encuentra un superadmin por su email
     * @param string $email Email del superadmin
     * @return object|false Objeto con datos del superadmin o false si no existe
     */
    public function findByEmail($email) {
        $query = "SELECT * FROM superadmin WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        }
        
        return false;
    }
    
    /**
     * Encuentra un superadmin por su ID
     * @param int $id ID del superadmin
     * @return object|false Objeto con datos del superadmin o false si no existe
     */
    public function findById($id) {
        $query = "SELECT * FROM superadmin WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        }
        
        return false;
    }
}
?>
