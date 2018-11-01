<?php

namespace test\validation;
use test\validation\core\Validate;
include_once 'Core/Validate.php';

class ContainUppercaseAndLowercaseValidate extends Validate
{
    const REGEX = '/.*[a-z].*[A-Z].*/';
    protected $mess = 'The password must contain at least one uppercase and at least one lowercase letter';
    public function validate($input){
        if (!preg_match(self::REGEX,$input)){
            return $this->buildResult(false, $this->mess);
        }
        return $this->buildResult(true, 'Success');
    }

}