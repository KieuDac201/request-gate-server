<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;

class ChangePasswordRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/
            |regex:/[0-9]/|regex:/[@$!%*#?&]/|different:old_password',
            'confirm_password' => 'required|same:new_password'
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
            //
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
