<?php

namespace App\Libs\Data;

use App\Libs\Field\FieldInterface;
use Illuminate\Database\Eloquent\Model;

interface ObjectTypeInterface
{
    
    /**
     * __construct
     *
     * @param  mixed $model
     * @return void
     */
    public function __construct(Model $model);
    
    
    /**
     * addField
     *
     * @param  mixed $field
     * @return void
     */
    public function addField(FieldInterface $field);
    
    /**
     * getFieldList
     *
     * @return void
     */
    public function getFieldList();
    
    /**
     * setPagination
     *
     * @param  mixed $pagination
     * @return void
     */
    public function setPagination(array $pagination);
    
    /**
     * setOrder
     *
     * @param  mixed $sortList
     * @return void
     */
    public function setOrder(array $sortList);
    
    /**
     * getOrder
     *
     * @return void
     */
    public function getOrder();

}
