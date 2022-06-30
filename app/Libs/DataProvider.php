<?php

namespace App\Libs;

use App\Libs\Data\ModelObject;
use App\Libs\Field\BooleanField;
use App\Libs\Field\DateField;
use App\Libs\Field\IntegerField;
use App\Libs\Field\TextField;
use Exception;


class DataProvider
{
    private $_params;
    private $_resource;
    private $_listName;
    private $_conditions = [];


    
    
    /**
     * __construct
     *
     * @param  mixed $params
     * @param  mixed $resource
     * @return void
     */
    public function __construct(array $params, ModelObject $resource)
    {

        if (empty($resource)) {
            throw new \Exception("resource model not defined", -1);
        }
        if (empty($params['list_name'])) {
            throw new \Exception("list name  not defined", -1);
        }

        $this->_resource = $resource;
        $this->_params = $params;
        $this->_listName = $params['list_name'];
        $this->_conditions = (isset($params['conditions']) && is_array($params['conditions'])) ? $params['conditions'] : [];
    }


    
    /**
     * 1 : add columns and set conditions
     * 2 : set list setting like pagination , order
     * make
     *
     * @return void
     */
    public function make()
    {
        $this->_addCoulmns();
        $this->_setListConfig();

        return [
            'metaData' => $this->_getMetaData(),
            'list' => $this->_getData()
        ];
    }

    
    /**
     * set Pagination and Order
     * _setListConfig
     *
     * @return void
     */
    private function _setListConfig()
    {
        if (isset($this->_params['pagination'])) {
            $this->_resource->setPagination($this->_params['pagination']);
        }

        if (isset($this->_params['order'])) {
            $this->_resource->setOrder($this->_params['order']);
        }
    }



    
    /**
     * create filed object and set conditions and details
     * _addCoulmns
     *
     * @return void
     */
    private function _addCoulmns()
    {
        if (empty($this->_params['columns'])) {
            throw new \Exception("columns not defined", -1);
        }


        foreach ($this->_params['columns'] as $column) {

            switch ($column['type']) {
                case "text":
                    $field = new TextField($column['type'], $column['name']);
                    break;
                case "integer":
                    $field = new IntegerField($column['type'], $column['name']);
                    break;
                case "date":
                    $field = new DateField($column['type'], $column['name']);
                    break;
                case "boolean":
                    $field = new BooleanField($column['type'], $column['name']);
                    break;
                case "default":
                    throw new Exception("undefined field type", -1);
                    break;
            }
            if (isset($column['caption'])) {
                $field->setCaption($column['caption']);
            }
            if (isset($column['width'])) {
                $field->setWidth($column['width']);
            }
            if (isset($column['searchable'])) {
                $field->setSearchable($column['searchable']);
            }

            if (!empty($this->_conditions) && isset($this->_conditions[$field->getName()])) {

                if (!$field->isSearchable()) {
                    throw new Exception($field->getName() . " is not a searchable field", -1);
                }
               
                $rule = $this->_conditions[$field->getName()];
                $field->setCondition($rule);
            }

            $this->_resource->addField($field);
        }

        return $this;
    }


    
    /**
     * _getMetaData
     *
     * @return void
     */
    private function _getMetaData()
    {
        return [
            "listName" => $this->_listName,
            "columns" => $this->_resource->getFieldList(),
        ];
    }

    
    /**
     * _getData
     *
     * @return void
     */
    private function _getData()
    {
        return $this->_resource->getData();
    }
}
