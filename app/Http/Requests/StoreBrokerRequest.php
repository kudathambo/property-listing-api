<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrokerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [$this->isPostRequest() , 'unique:brokers', 'max:255'],
            'address' => [$this->isPostRequest()  , 'max:255'],
            'city' => [$this->isPostRequest()  ],
            'phone_number' => [$this->isPostRequest() , 'min:9' ],
            'logo_path' => [$this->isPostRequest() ],
        ];
    }

    private function isPostRequest(): string
    {
        return request()->isMethod('post') ? 'required' : 'sometimes';
    }
}
