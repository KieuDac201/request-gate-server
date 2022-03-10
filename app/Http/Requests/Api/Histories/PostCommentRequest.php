<?php

namespace App\Http\Requests\Api\Histories;

use App\Http\Requests\Api\ApiRequest;

class PostCommentRequest extends ApiRequest
{
    /**
     * Get custom rules for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'content' => 'required||max:1000',
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
