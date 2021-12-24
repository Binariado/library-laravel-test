<?php

namespace App\Http\Requests;

use App\helper\RequestFailedMessage;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class StoreAssignRoleRequest extends FormRequest
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

        return $user->can('Assign role');
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
            'user_id' => 'required|integer|exists:App\Models\User,id',
            'role_id' => 'required|integer|exists:Spatie\Permission\Models\Role,id'
        ];
    }
}
