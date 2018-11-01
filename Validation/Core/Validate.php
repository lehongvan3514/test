<?php

namespace test\validation\core;

abstract class Validate
{
    protected $mess;
    abstract function validate($input);

    protected function buildResult($res, $mess){
        return [
            'res' => $res,
            'mess' => $mess,
        ];
    }
}