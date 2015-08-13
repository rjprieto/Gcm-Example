<?php 
class DB_Connect { 
    private $conexion;
	
	// constructor 
    function __construct() { 
    } 
    // destructor 
    function __destruct() { 
        //$this->close(); 
    } 

    // Conexion a la DB 
    public function connect() { 
        require_once 'config.php'; 
        
		// conectando con mysql 
		if (DB_TYPE === MYSQL) {
			$this->conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD); 
			mysql_select_db(DB_DATABASE);  // Seleccionando nuestra DB 
			
			$sql="CREATE TABLE IF NOT EXISTS 'gcm_devices' ( 
			  'id' int(11) NOT NULL AUTO_INCREMENT, 
			  'gcm_regid' text, 
			  'name' varchar(50) NOT NULL, 
			  'email' varchar(255) NOT NULL, 
			  'created_at' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
			  PRIMARY KEY ('id') 
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
			//¿Ejecutar?
		}
		else if (DB_TYPE === POSTGRES) {
			$this->conexion = pg_connect("host=" . DB_HOST . " dbname=" . DB_DATABASE . " user=" . DB_USER . " password=" . DB_PASSWORD) or die('No se ha podido conectar: ' . pg_last_error());

			$sql="CREATE TABLE IF NOT EXISTS gcm_devices (
				id SERIAL, 
				gcm_regid text, 
				name varchar(50) NOT NULL, 
				email varchar(255) NOT NULL, 
				created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
				PRIMARY KEY(id)
			)";
			pg_exec($this->conexion, $sql);
		}
        return $this->conexion; 
    }
	
    // cerrando nuestra conexion 
    public function close() { 
        if (DB_TYPE === MYSQL) {
			mysql_close(); 
		}
		else if (DB_TYPE === POSTGRES) {
			pg_close($this->conexion);
		}
    } 
} 
?>