<?php

namespace App\Libs\Field;

use Exception;


class IntegerField extends FieldAbstract  implements FieldInterface
{

    
    /**
     * getValidCondition
     *
     * @return void
     */
    public function getValidCondition()
    {
        return [">", "=" , ">="];
    }
    
    /**
     * setCondition
     *
     * @param  mixed $rule
     * @return void
     */
    public function setCondition($rule)
    {
        foreach ($rule as $key => $value) {
          
            if (!in_array($key, $this->getValidCondition())) {
                throw new Exception("not valid condition for integer input");
            }

            $this->_condition[] = [
                "column_name" => $this->getName(),
                "column_value" => $value,
                "condition" => $key
            ];
        }

       
        return $this;
    }

}
