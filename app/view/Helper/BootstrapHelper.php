<?php
class BootstrapHelper extends BaseHelper {
    
    protected $errors;
    protected $values;
    
    public function __construct($errors, $values) {
        $this->errors = $errors;
        $this->values = $values;
    }
    
    public function input($name, $options = NULL) {
        $inputInfo = parent::input($name, $options);
        $inputInfo['div_class'] = 'form-group';
        if($inputInfo['error_msg']) {
            $inputInfo['error_html'] = '<span class="help-block">' . $inputInfo['error_msg'] . '</span>';
            $inputInfo['div_class'] = 'form-group has-error';            
        } else {
            $inputInfo['error_html'] = '';
        }
        return $inputInfo;
    }
}