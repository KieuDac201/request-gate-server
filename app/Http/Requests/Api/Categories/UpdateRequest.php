<?php

namespace App\Http\Requests\Api\Categories;

use App\Http\Requests\Api\ApiRequest;

class UpdateRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'       => 'required',
            'status'     => 'required',
            'user_id'    => 'required'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'status.required' => 'A status is required',
            'user_id.required' => 'A assignee is required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }
}
