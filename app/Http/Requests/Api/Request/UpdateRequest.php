<?php

namespace App\Http\Requests\Api\Request;

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
            'content'   => 'required',
            'priority'  => 'required',
            'status'    => 'required',
            'category_id' => 'required|exists:categories,id',
            'person_in_charge' => 'required|exists:users,id',
            'due_date'  => 'required|date|after:yesterday',
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
            'content.required' => 'A content is required',
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
