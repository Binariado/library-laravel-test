<?php

namespace App\Http\Requests;

use App\helper\RequestFailedMessage;
use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLibraryRequest extends FormRequest
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

        return $user->can('Create library');
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'book_archive' => 'required|string|max:255',
            'author_id' => 'required|integer|exists:App\Models\Author,id',
            'editor_id' => 'required|integer|exists:App\Models\Editor,id',
            'publisher_id' => 'required|integer|exists:App\Models\Publisher,id',
            'gender' => 'required|string',
            'language_id' => 'required|integer|exists:App\Models\Language,id',
            'date_of_publication' => 'required|string|max:255',
            'number_page' => 'required|integer',
            'image' => 'image'
        ];
    }
}
