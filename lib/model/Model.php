<?php

require(__DIR__ . '/component/Validation.php');
require(__DIR__ . '/DbConnector.php');

/**
 * The Model base class
 */
class Model {

    private $validation;
    private $databaseConfig;
    private $errors;
    private $dbObj;

    function __construct() {
        $this->validation = new Validation();
        $this->databaseConfig = new Database();
    }

    /**
     * This function is used to load a controller
     * @param string $controller Name of the controller	
     * @return boolean - True if controller was loaded, else false.
     */
    final static function Load($model) {
        $modelPath = APP_PATH . MODEL_FOLDER . DS . $model . '.php';
        if (file_exists($modelPath)) {
            include($modelPath);
            return true;
        }
        return false;
    }

    final public function save($data) {
        $className = get_class($this);
        $hasErrors = $this->validation->validateProps($data, $this, $this->validate);
        if ($hasErrors) {
            return ErrorType::VALIDATION_ERROR;
        }
        $modelInfo = Model::getModelInfo($className, $this->databaseConfig);
        $dbConfig = $modelInfo['databaseConfig'];
        $tableName = $modelInfo['table'];
        $databaseName = $modelInfo['databaseName'];

        $arrayKeys = array_keys($data[$className]);
        $arrayKeysPDO = Model::getPDOArrayKeys($arrayKeys);
        $sqlQuery = "INSERT INTO $databaseName.$tableName (" . implode($arrayKeys, ',') .
                ') VALUES (' . implode($arrayKeysPDO, ',') . ');';

        $paramsBind = array();
        for ($i = 0, $len = count($arrayKeys); $i < $len; ++$i) {
            $paramsBind[$arrayKeysPDO[$i]] = $data[$className][$arrayKeys[$i]];
        }
        try {
            $this->dbObj = new DbConnector($dbConfig);
            if ($this->dbObj->bindValues($paramsBind, $sqlQuery)->execute()) {
                return ErrorType::DATABASE_ERROR;
            } else {
                $this->id = $this->dbObj->getLastInsertedId();
                return ErrorType::NONE;
            }
        } catch (PDOException $e) {
            return ErrorType::DATABASE_ERROR;
        }
    }
    
    final public function getErrors() {
        return $this->validation->getErrors();
    }

    private static function getModelInfo($className, $defaultConfig) {
        $options = array(
            'table' => 'className'
        );
        $classObj = new $className();
        $options['table'] = isset($classObj->table) ? $classObj->table : $className;
        $options['databaseConfig'] = isset($classObj->database) ? $this->databaseConfig[$classObj->database] : $defaultConfig->default;
        $options['databaseName'] = $options['databaseConfig']['database'];
        return $options;
    }

    private static function getPDOArrayKeys($props) {
        $PDOKeys = array();
        foreach ($props as $prop) {
            $PDOKeys[] = ":$prop";
        }
        return $PDOKeys;
    }

}

?>