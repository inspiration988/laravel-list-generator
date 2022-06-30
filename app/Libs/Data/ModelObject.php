<?php

namespace App\Libs\Data;

use App\Libs\Field\FieldInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ModelObject implements ObjectTypeInterface
{
    private  $fields = [];
    private  $conditions = [];

    private  $sorts = [];
    private $_model;
    private $_pageSize = 10;
    private $_pageNumber = 0;

    /**
     * __construct
     *
     * @param  mixed $model
     * @return void
     */
    public function __construct(Model $model)
    {
        if (!$model instanceof Model) {
            throw new \Exception("Class {$model} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->_model = $model;
    }


    /**
     * this method fill the arrays conditions and columns
     * addField
     *
     * @param  mixed $field
     * @return void
     */
    public function addField(FieldInterface $field)
    {

        if (!$this->_isFieldExsit($field->getName())) {

            throw new Exception("field " . $field->getName() . " is not exist in model " . $this->_model::class);
        }
        $this->fields[] = [
            'name' => $field->getName(),
            'caption' => $field->getCaption(),
            'width' => $field->getWidth(),
        ];


        $this->conditions[] = $field->getCondition();

        return $this;
    }

    /**
     * return the array list of fields
     * getFieldList
     *
     * @return void
     */
    public function getFieldList()
    {
        return $this->fields;
    }



    /**
     * setPagination
     *
     * @param  mixed $pagination
     * @return void
     */
    public function setPagination(array $pagination)
    {

        if (isset($pagination['pageSize'])) {
            $this->_pageSize  = $pagination['pageSize'];
        }
        if (isset($pagination['pageNumber'])) {
            $this->_pageNumber  = $pagination['pageNumber'];
        }

        return $this;
    }



    /**
     * setOrder
     *
     * @param  mixed $sortList
     * @return void
     */
    public function setOrder(array $sortList)
    {

        if (!empty($sortList)) {

            foreach ($sortList as $key => $value) {

                if (!$this->_isValidFieldKey($key)) {

                    throw new \Exception("sort key is not exist in filed list", -1);
                }
                $this->sorts[$key] = $value;
            }
        }
        return $this;
    }


    /**
     * getOrder
     *
     * @return void
     */
    public function getOrder()
    {
        return  $this->sorts;
    }

    /**
     * where
     *
     * @return void
     */
    private function where()
    {

        if (!empty($this->conditions)) {

            foreach ($this->conditions as $conditions) {
                if (!empty($conditions)) {
                    foreach ($conditions as $condition) {
                        $this->_model = $this->_model->where($condition['column_name'], $condition['condition'], $condition['column_value']);
                    }
                }
            }
        }
        return $this;
    }




    /**
     * orderBy
     *
     * @return void
     */
    private function orderBy()
    {

        if (!empty($this->getOrder())) {
            $orders = $this->getOrder();
            foreach ($orders as $key => $value) {
                $this->_model =  $this->_model->orderBy($key, $value);
            }
        }
        return $this;
    }
    
    /**
     * pagination
     *
     * @return void
     */
    private function pagination()
    {
        $this->_model = $this->_model->offset(($this->_pageNumber) * $this->_pageSize)->limit($this->_pageSize);
        return $this;
    }

        
    /**
     * select
     *
     * @return void
     */
    private function select()
    {

        $fieldNames = array_map(function ($b) {
            return $b['name'];
        }, $this->getFieldList());

        $this->_model = $this->_model->select($fieldNames);

        return $this;
    }
    
    /**
     * all
     *
     * @return void
     */
    private function all()
    {
        return $this->_model->get()->toArray();
    }
    
    /**
     * getData
     *
     * @return void
     */
    public function getData()
    {
        return $this->select()->where()->orderBy()->pagination()->all();
    }

    
    /**
     * _isValidFieldKey
     *
     * @param  mixed $key
     * @return void
     */
    private function _isValidFieldKey($key)
    {
        $fieldNames = [];

        if (!empty($this->fields)) {
            foreach ($this->fields as $field) {

                $fieldNames[] = $field['name'];
            }

            return (in_array($key, $fieldNames));
        }
    }
    
    /**
     * _isFieldExsit
     *
     * @param  mixed $field
     * @return void
     */
    private function _isFieldExsit($field)
    {
        /**
         * @todo
         * should check if the column name is exist in model or not
         * 
         */
        return true;
    }
}
