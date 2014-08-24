<?php

class BaseHelper {

    protected $ctrlPrefix = array('select' => 'ddl', 'text' => 'txt', 'password' => 'txt', 'checkbox' => 'chk', 'radio' => 'rdo');
    protected $errors;
    protected $values;

    public function __construct($errors, $values) {
        $this->errors = $errors;
        $this->values = $values;
    }

    public function input($name, $options = NULL) {
        $inputInfo = array(
            'id' => '',
            'name' => $name,
            'type' => 'text',
            'options' => array(),
            'options_html' => '',
            'value' => '',
            'label' => '',
            'error_msg' => false,
        );
        if(empty($options)) {
            $options = array();
        }
        $ctrlName = '';
        $model = '';
        $inputInfo['name'] = $this->getInputName($name, $ctrlName, $model);
        $inputInfo['type'] = $this->getType($options);             
        $inputInfo['label'] = $this->getLabel($options, $ctrlName);
        $inputInfo['value'] = $this->getValue($ctrlName, $model);
        $inputInfo['options'] = $this->getOptions($options);
        $inputInfo['error_msg'] = $this->getError($ctrlName);
        $inputInfo['default'] = isset($options['default']) ? $options['default'] : '';
        if($inputInfo['type'] === 'select' && count($inputInfo['options']) !== 0) {
            $inputInfo['options_html'] = $this->getOptionsHtml($inputInfo);
        }
        return $inputInfo;
    }

    protected function getInputName($name, &$ctrlName, &$model) {
        $name = explode(".", $name);
        $model = '';
        $ctrlName = $name[0];
        if (count($name) === 2) {
            $model = $name[0];
            $ctrlName = $name[1];
            return "data[$model][$ctrlName]";
        }
        return $ctrlName;
    }

    protected function getType($options) {
        if (!empty($options['type'])) {
            return $options['type'];
        }
        return 'text';
    }

    protected function getLabel($options, $ctrlName) {
        if (isset($options['label'])) {
            return $options['label'];
        }
        return ucfirst($ctrlName);
    }

    protected function getValue($ctrlName, $model) {
        if (empty($model)) {
            return $this->values[$ctrlName];
        } else {
            if(empty($this->values[$model][$ctrlName])) {
                return;
            } else {
                return $this->values[$model][$ctrlName];
            }            
        }
    }

    protected function getError($ctrlName) {
        if (isset($this->errors[$ctrlName])) {
            return $this->errors[$ctrlName];
        }
        return false;
    }

    protected function getClass($options) {
        if (!empty($options['class'])) {
            return $options['class'];
        } else {
            return array();
        }
    }

    protected function getData($options) {
        if (isset($options['data'])) {
            return $options['data'];
        }
        return array();
    }
    
    protected function getOptions($options) {
        if(isset($options['options'])) {
            return $options['options'];
        }
        return array();
    }
    
    protected function getOptionsHtml($inputInfo) {
        $defaultVal = $inputInfo['default'];
        $options = $inputInfo['options'];
        $value = $inputInfo['value'];
        $optionsHtml = "<option value=\"\">$defaultVal</option>";
        foreach($options as $index=>$text) {
            if($value === $index) {
                $optionsHtml .= '<option value="' . $index . '" selected="selected">' . $text . '</option>';
            }
            $optionsHtml .= '<option value="' . $index . '">' . $text . '</option>';
        }
        return $optionsHtml;
    }
}
