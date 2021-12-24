<?php

namespace App\Http\Requests;

use App\helper\RequestFailedMessage;
use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    use RequestFailedMessage;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:authors|string|max:255'
        ];
    }


}
