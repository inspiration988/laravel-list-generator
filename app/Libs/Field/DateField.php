<?php

namespace App\Libs\Field;

use Carbon\Carbon;
use Exception;

class DateField extends FieldAbstract  implements FieldInterface
{
    
    /**
     * getValidCondition
     *
     * @return void
     */
    public function getValidCondition()
    {
        return ["between", ">=", "<=", ">", "<"];
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

            if (empty($value) || count($value) > 2) {
                throw new Exception("for date input you can just set 2 value to search");
            }
            if (!in_array($key, $this->getValidCondition())) {
                throw new Exception("not valid condition for date input");
            }

            $start = $value[0];
           
            if ($key == 'between') {

                $this->_condition[] = [
                    "column_name" => $this->getName(),
                    "column_value" => $start,
                    "condition" => ">="
                ];
                if (isset($value[1])) {
                   
                    $end = $value[1];
                    if($end<$start){
                        throw new Exception("stard date should be less than end date");
                    }
                    $this->_condition[] = [
                        "column_name" => $this->getName(),
                        "column_value" => $end,
                        "condition" => "<="
                    ];
                }
            } else {
                $this->_condition[] = [
                    "column_name" => $this->getName(),
                    "column_value" => $start,
                    "condition" => $key
                ];
            }
        }
    

        return $this;
    }
    
}
