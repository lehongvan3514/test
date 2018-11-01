<?php

namespace test\validation;
use test\validation\core\Validate;
include_once 'Core/Validate.php';

class LengthValidate extends Validate
{
    protected $mess = 'The password must be at least 6 characters long';
    public function validate($input){
        if (strlen($input) <6){
            return $this->buildResult(false, $this->mess);
        }
        return $this->buildResult(true, 'Success');
    }
}