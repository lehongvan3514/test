<?php

namespace test\validation;
use test\validation\core\Validate;
include_once 'Core/Validate.php';

class ContainDigitAndSymbolValidate extends Validate
{
    const REGEX = '/.*\d.*\W.*/';
    protected $mess = 'The password mus have at least one digit and symbol';
    public function validate($input){
        if (!preg_match(self::REGEX,$input)){
            return $this->buildResult(false, $this->mess);
        }
        return $this->buildResult(true, 'Success');
    }
}