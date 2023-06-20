<?php

namespace App\Http\Requests\PostsRequests;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoringPostRequest extends FormRequest
{
    use GeneralTrait;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cotent'=>'required|string',
            'price'=>'required|numeric',
            'photos'=>'nullable|array|min:1',
            'photos.*'=>'image|mimes:png,jpg,jpeg',
        ];
    }
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            $this->returnValidationError(202, $this->returnCodeAccordingToInput($validator), $validator)
        );
    }
}
