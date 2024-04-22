<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ListRequest extends FormRequest
{
    public static $rules = [
        'title' => 'required',
        'description' => 'nullable',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return static::$rules;
    }

    public function after()
    {
        return [
            function (Validator $validator) {
                /* if ($this->somethingElseIsInvalid()) {
                    $validator->errors()->add(
                        'field',
                        'Something is wrong with this field!'
                    );
                } */

                /* dd($validator->errors()); */
            }
        ];
    }
}
