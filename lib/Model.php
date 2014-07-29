<?php
/**
* The Model base class
*/
public class Model {

    protected $db;
    private $stmt;
    private $prefix;
	
	/**
	* Initializes a connection to the database.
	* @param string $dbSetting	
	* @return
	*/
    public function __construct($dbSetting = 'default') {
        $dbConfig = DATABASE_CONFIG::{
            $dbSetting
        };
        $server = $dbConfig['host'];
        $dbName = $dbConfig['database'];
        $username = $dbConfig['login'];
        $password = $dbConfig['password'];
        $this->prefix = empty($dbConfig['prefix']) ? '' : $dbConfig['prefix'];
        $isPersistent = array(PDO::ATTR_PERSISTENT => $dbConfig['persistent']);
        $this->db = new PDO(
            "mysql:host=$server;dbname=$dbname",
            $username, $password, $isPersistent
        );
    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
        return $this;
    }

    public function bind($pos, $value, $type = null) {
        if ( is_null($type) ) {
            $type = $this->getType($value);
        }

        $this->stmt->bindValue($pos, $value, $type);
        return $this;
    }

    public function bindVals($arr) {
        foreach ($arr as $key => $value) {
            $type = $this->getType($value);
            $this->stmt->bindValue($key, $value, $type);
        }
        return $this;
    }

    public function execute() {
        return $this->stmt->execute();
    }
    
    public function resultset() {
        if($this->execute()) {
			return $this->stmt->fetchAll();	
		}
        return false;
    }

    public function single() {
    	if($this->execute()) {
			return $this->stmt->fetch();
		}
       	return false;
        
    }

    private function getType($value) {
        switch (true) {
            case is_int($value):
            return PDO::PARAM_INT;
            case is_bool($value):
            return PDO::PARAM_BOOL;
            case is_null($value):
            return PDO::PARAM_NULL;
            default:
            return PDO::PARAM_STR;
        }
    }
}
?>