<?php 
class DB_Functions { 
    private $db; 
	
    function __construct() { 
        include_once 'connect.php';
		include_once 'config.php';
		
        // Conectando con la DB 
        $this->db = new DB_Connect(); 
        $this->db->connect(); 
    } 
    function __destruct() { 
    }
	
    /*---- Almacenando nuevo usuario ----*/ 
    public function storeUser($name, $email, $gcm_regid) { 
		if (DB_TYPE === MYSQL) {
			// Insertamos el usuario en la DB 
			$result = mysql_query("INSERT INTO gcm_devices(name, email, gcm_regid, created_at) VALUES('$name', '$email', '$gcm_regid', NOW())"); 
			
			// Verificamos que se insertó correctamente 
			if ($result) { 
				// obtenemos los detalles del usuario 
				$id = mysql_insert_id(); // ultimo ID insertado 
				$result = mysql_query("SELECT * FROM gcm_devices WHERE id = $id") or die(mysql_error()); 
				// retornamos detalles del usuario 
				if (mysql_num_rows($result) > 0) { 
					return mysql_fetch_array($result); 
				} else { 
					return false; 
				} 
			} else { 
				return false; 
			} 
		}
		else if  (DB_TYPE === POSTGRES) {
			// Insertamos el usuario en la DB 
			$result = pg_query("INSERT INTO gcm_devices(name, email, gcm_regid, created_at) VALUES('$name', '$email', '$gcm_regid', NOW())") or die('La consulta fallo: ' . pg_last_error());; 
			
			// Verificamos que se insertó correctamente 
			if ($result) { 
				// obtenemos los detalles del usuario 
				
				$insert_query = pg_query("SELECT lastval();");
				$insert_row = pg_fetch_row($insert_query);
				$id = $insert_row[0];
			   
				$result = pg_query("SELECT * FROM gcm_devices WHERE id = $id") or die('La consulta fallo: ' . pg_last_error());
				// retornamos detalles del usuario 
				if (pg_affected_rows($result) > 0) { 
					return pg_fetch_array($result, null, PGSQL_ASSOC);
				} else { 
					return false; 
				} 
			} else { 
				return false; 
			} 
		}

		
		
    } 
	
    /*--- Obtenemos todos los usuarios registrados ----*/ 
    public function getAllUsers() { 
        if (DB_TYPE === MYSQL) {
			$result = mysql_query("SELECT * FROM gcm_devices");
		}
		else if  (DB_TYPE === POSTGRES) {
			$result = pg_query("SELECT * FROM gcm_devices") or die('La consulta fallo: ' . pg_last_error());
		}
        return $result; 
    } 
	
	public function fetchUsers($users) {
		if (DB_TYPE === MYSQL) {
			return mysql_fetch_array($users);
		}
		else if  (DB_TYPE === POSTGRES) {
			return pg_fetch_array($users, null, PGSQL_ASSOC);
		}
	}
}

?>