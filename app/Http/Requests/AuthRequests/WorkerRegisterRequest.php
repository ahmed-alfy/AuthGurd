<?php

namespace App\Http\Requests\AuthRequests;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class WorkerRegisterRequest extends FormRequest
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

        // $guard = 'worker';

        return [
            'name' => 'required|string|between:2,100',
            'password' => 'required|string',
            'phone' => "required|string",
            'photo' => "required|image|mimes:png,jpg",
            "location" => "required|string",
            'email' => [
                'required', 'string', 'email', 'max:100','unique:workers,email'
            ],

            // 'email' => [  Rule::unique($guard . 's')->where(function ($query) use ($guard) {
            //         $query->where('email', request()->input('email'));
            //     }),
            // ]


        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            $this->returnValidationError(202, $this->returnCodeAccordingToInput($validator), $validator)
        );
    }
}
