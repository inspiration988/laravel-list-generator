<?php

namespace App\Libs\Field;


interface FieldInterface
{

    /**
     * setCondition
     *
     * @param  mixed $rule
     * @return void
     */
    public function setCondition($rule);


    /**
     * getValidCondition
     *
     * @return void
     */
    public function getValidCondition();
}
