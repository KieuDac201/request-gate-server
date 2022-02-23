<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;

class StoreRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'       => 'required|email',
            'password'    => 'required',
            'name'      => 'required|max:25',
            'role_id'   => 'exists:roles,id',
            'department_id' =>  'exists:departments,id',
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
            'name.max' =>   'Ten khong duoc qua 25 ky tu',
            'email.required' => 'A email is required',
            'password.required' => 'A password is required',
            'name.required' => 'A name is required',
            'email.email'   =>  'Khong dung dinh dang',
            'role_id.exists' => 'Role nay chua ton tai',
            'department_id.exists' =>  'Phong ban nay chua ton tai'
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
            'email' => 'email address',
        ];
    }
}
