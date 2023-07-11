<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CompanyUpdateRequest extends FormRequest
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
        $identificadorUuid = $this->company;

        return [
            'name' => "min:3|max:100|unique:companies,name,{$identificadorUuid},uuid",
            'phone' => "min:3|max:12|unique:companies,phone,{$identificadorUuid},uuid",
            'whatsapp' => "min:3|max:12|unique:companies,whatsapp,{$identificadorUuid},uuid",
            'email' => "email|unique:companies, email,{$identificadorUuid},uuid",
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
