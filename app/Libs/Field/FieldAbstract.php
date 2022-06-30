<?php

namespace App\Libs\Field;

use phpDocumentor\Reflection\Types\Boolean;

abstract class FieldAbstract
{
    protected $_type;
    protected $_name;
    protected $_caption;
    protected $_width = 30;
    protected $_order;

    protected $_searchable = true;
    protected $_condition = [];
    
    /**
     * __construct
     *
     * @param  mixed $type
     * @param  mixed $name
     * @return void
     */
    public function __construct(string $type,string $name)
    {

        $this->_type = $type;
        $this->_name = $name;
    }

    
    /**
     * getName
     *
     * @return void
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * getType
     *
     * @return void
     */
    public function getType()
    {
        return $this->_type;
    }

    
    /**
     * setSearchable
     *
     * @param  mixed $filter
     * @return void
     */
    public function setSearchable($filter)
    {
        $this->_searchable = $filter;
    }
    
    /**
     * isSearchable
     *
     * @return void
     */
    public function isSearchable()
    {
        return $this->_searchable;
    }
    
    /**
     * setOrder
     *
     * @param  mixed $order
     * @return void
     */
    public function setOrder(int $order)
    {
        $this->_order = $order;
    }
    
    /**
     * getOrder
     *
     * @return void
     */
    public function getOrder()
    {
        return $this->_order;
    }
    
    /**
     * setCaption
     *
     * @param  mixed $caption
     * @return void
     */
    public function setCaption($caption)
    {
        $this->_caption = $caption;
    }  
      
    /**
     * getCaption
     *
     * @return void
     */
    public function getCaption()
    {
        return $this->_caption;
    }
    
    /**
     * setWidth
     *
     * @param  mixed $width
     * @return void
     */
        
    /**
     * setWidth
     *
     * @param  mixed $width
     * @return void
     */
    public function setWidth(int $width)
    {
        $this->_width = $width;
    }
    
    /**
     * getWidth
     *
     * @return void
     */
    public function getWidth()
    {
        return $this->_width;
    }

     /**
     * getCondition
     *
     * @return void
     */
    public function getCondition(){
        return $this->_condition;
    }

}
