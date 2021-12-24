<?php

namespace App\Http\Requests;

use App\helper\RequestFailedMessage;
use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class UpdatePublisherRequest extends FormRequest
{
    use RequestFailedMessage;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return false;
        }

        return $user->can('Update publisher');
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws abort
     */
    protected function failedAuthorization()
    {
        abort(
            response()->json(['message' => 'Unauthorized.'],
                Response::HTTP_FORBIDDEN
            )
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:publishers|string|max:255'
        ];
    }
}
