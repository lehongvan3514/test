<?php

namespace test\validation;
use test\validation\core\Validate;
include_once 'Core/Validate.php';

class WhiteSpaceValidate extends Validate
{
    const REGEX = '/\s/';
    protected $mess = 'The password must not contain any whitespace';
    public function validate($input){
        if (preg_match(self::REGEX,$input)){
            return $this->buildResult(false, $this->mess);
        }
        return $this->buildResult(true, 'Success');
    }
}