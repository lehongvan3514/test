<?php

namespace test;
use test\validation\ContainUppercaseAndLowercaseValidate;
use test\validation\ContainDigitAndSymbolValidate;
use test\validation\LengthValidate;
use test\validation\WhiteSpaceValidate;
include_once 'Validation/ContainDigitAndSymbolValidate.php';
include_once 'Validation/ContainUppercaseAndLowercaseValidate.php';
include_once 'Validation/LengthValidate.php';
include_once 'Validation/WhiteSpaceValidate.php';

class ValidateFactory
{
    public static function create($type){
        switch ($type){
            case 'DigitAndSymbol':
                $validation =  new ContainDigitAndSymbolValidate;
                break;
            case 'UpperAndLower':
                $validation =  new ContainUppercaseAndLowercaseValidate;
                break;
            case 'Length':
                $validation = new LengthValidate;
                break;
            case 'WhiteSpace':
                $validation = new WhiteSpaceValidate;
                break;
            default:
                $validation = null;
                break;
        }
        return $validation;
    }
}