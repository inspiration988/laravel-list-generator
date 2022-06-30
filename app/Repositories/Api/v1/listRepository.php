<?php

namespace App\Repositories\Api\v1;

use App\Libs\Data\ModelObject;
use App\Libs\DataProvider;
use App\Models\Api\v1\Customer;
use App\Models\Api\V1\ListSetting;
use App\Repositories\BaseRepository;
use Exception;

/**
 * Class ListRepository 
 * @package App\Repositories\Api\v1
 * @version April 19, 2022, 3:11 pm +03
 */

class ListRepository   extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ListSetting::class;
    }
    
    /**
     * in this method if the list_id is sent :
     * it means there is a need to update the list
     * and the inputs for dataProvider should reCalculate based on the new inputs 
     * and the previous data that already is saved in Database
     * and finally all the data will stored in Database
     *
     * @param  mixed $input
     * @return void
     */
    public function create($input)
    {

        // generate list
        $resource = new Customer();
        if (isset($input['list_id'])) {
            $ListSetting = ListSetting::find($input['list_id']);
            if (is_null($ListSetting)) {
                throw new Exception("list id is not exist", -1);
            }


            $savedColumns = json_decode($ListSetting['columns'], 1);
            $saColumnsNames = array_map(function ($a) {
                return $a['name'];
            }, $savedColumns);

            $inColumnsNames = array_map(function ($b) {
                return $b['name'];
            }, $input['columns']);

            $diff = array_diff($saColumnsNames, $inColumnsNames);

            $finalInputCoulmns = array_filter($savedColumns, function ($a) use ($diff) {
                return in_array($a['name'], $diff);
            });

            $finalInputCoulmns = array_merge($finalInputCoulmns, $input['columns']);

            $this->finalInput = [
                "list_name" => isset($input['list_name']) ? $input['list_name'] :  $ListSetting['name'],
                "columns" => $finalInputCoulmns,
                "conditions" => isset($input['conditions']) ? $input['conditions'] : null,
                "order" => isset($input['order']) ? $input['order'] : null,
                "pagination" => isset($input['pagination']) ? $input['pagination'] : null,
            ];
            $dataProvider = new DataProvider($this->finalInput, new ModelObject($resource));
        } else {
            $dataProvider = new DataProvider($input, new ModelObject($resource));
        }

        // make list
        $resultDataProvider = $dataProvider->make();


        //save  list details in db
        if (isset($input['list_id'])) {
            $this->model = $this->model::find($input['list_id']);
            $this->model->columns = json_encode($this->finalInput['columns']);
            $this->model->name = isset($input['list_name']) ? $input['list_name'] : $this->model['name'];
        } else {
            $this->model->name = $input['list_name'];
            $this->model->columns = json_encode($input['columns']);
        }

        if (!$this->model->save()) {
            throw new Exception("list not saved!", -1);
        }

        return [
            "status" => 1,
            "message" => [
                "listID" => $this->model->id,
                "dataProdvider" => $resultDataProvider
            ]
        ];
    }
}
