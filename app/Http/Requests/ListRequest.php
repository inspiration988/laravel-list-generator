<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'list_name' => 'required|string',
            'list_id' => 'integer',

            'columns' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {

                    foreach ($value as $val) {
                        if (!in_array($val['type'], ["text", "date", "integer", "boolean"])) {
                            $fail($val['type'] . ' type is invalid.');
                        }
                        if (isset($val['searchable']) && !in_array($val['searchable'], [0, 1])) {
                            $fail($val['searchable'] . ' value is invalid.only 0|1');
                        }
                        if (isset($val['width']) && !is_numeric($val['width'])) {
                            $fail('width should be numeric.');
                        }
                        if (isset($val['caption']) && is_numeric($val['caption'])) {
                            $fail('caption should be string.');
                        }
                        if (is_numeric($val['name'])) {
                            $fail('name should be string.');
                        }
                    }
                },
            ],
            'conditions' => 'array',
            'pagination' => 'array',
            'pagination.pageSize' => 'numeric|min:1',
            'pagination.pageNumber' => 'numeric|min:0',
            'order' => 'array',

            'order[1]' => [Rule::in("asc", "desc")],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(Response::failed($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
