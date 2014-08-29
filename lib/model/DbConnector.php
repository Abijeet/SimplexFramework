<?php

class DbConnector {

    private $PDO;
    private $dbOptions;
    private $dbParams; 
    private $stmt;
    
    private $default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'encoding' => 'utf8',
    );

    public function __construct($dbConn) {
        $this->dbOptions = $this->getFinalDbOptions($dbConn, $this->default);
        if(empty($this->dbOptions)) {
            throw new Exception('Invalid db parameters!');
        }
        $this->dbParams = $this->getDbParams($this->dbOptions);
        $this->PDO = new PDO($this->dbParams['db_string'], $this->dbParams['user'], $this->dbParams['password']);
        $this->PDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

    public function bindValues($paramsToBind, $stmt) {
        $this->stmt = $this->PDO->prepare($stmt);
        foreach($paramsToBind as $param => $value) {
            $this->stmt->bindValue($param, $value);
        }
        return $this;
    }
    
    public function execute() {
        return $this->stmt->execute();
    }
    
    public function getLastInsertedId() {
        return $this->PDO->lastInsertId();
    }
    
    private function getFinalDbOptions($dbConn, $default) {
        $finalDbConfig = array();
        if (isset($dbConn['host']) && isset($dbConn['database']) && isset($dbConn['login']) && isset($dbConn['password'])) {
            $finalDbConfig['host'] = $dbConn['host'];
            $finalDbConfig['database'] = $dbConn['database'];
            $finalDbConfig['login'] = $dbConn['login'];
            $finalDbConfig['password'] = $dbConn['password'];
            $finalDbConfig['datasource'] = empty($dbConn['datasource']) ? $default['datasource'] : $dbConn['datasource'];
            $finalDbConfig['persistent'] = empty($dbConn['persistent']) ? $default['persistent'] : $dbConn['persistent'];
            $finalDbConfig['encoding'] = empty($dbConn['encoding']) ? $default['encoding'] : $dbConn['encoding'];
            return $finalDbConfig;
        }
        return false;
    }

    private function getDbParams($options) {
        $connString = 'mysql:host=' . $options['host'] . ';dbname=' . $options['database']; 
        return array('user' => $options['login'], 'password' => $options['password'], 'db_string' => $connString);
    }
}
