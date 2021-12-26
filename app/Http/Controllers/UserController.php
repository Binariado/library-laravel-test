<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        foreach ($users as $item) {
            $item->usersBorrowedBook;
        }

        return response()->json(array(
            'message' => 'List users',
            'data' => $users
        ), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {

        $user->usersBorrowedBook;

        return response()->json(array(
            'message' => 'Show user',
            'data' => $user
        ), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {

        if (
            auth()->user()->id != $user->id
            && !auth()->user()->hasRole('admin')
        ) {
            return response()->json(array(
                'message' => 'Unauthorized',
            ), Response::HTTP_FORBIDDEN);
        }

        $user->update($request->all());

        $user->save();

        return response()->json(array(
            'message' => 'Delete user',
            'data' => $user
        ), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(array(
            'message' => 'Delete user',
            'data' => $user
        ), Response::HTTP_OK);
    }

    public function banUser(Request $request, User $user): JsonResponse{

        $user->update([
            'banned' => $request->get('banned')
        ]);
        $user->save();

        return response()->json(array(
            'message' => 'banned user',
            'data' => $user
        ), Response::HTTP_OK);
    }

    public function image(Request $request, User $user): JsonResponse {

        $validator = Validator::make($request->all(), [
            'image' => ['required', '']
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        if ( Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')
                ->delete($user->image);
        }

        $path = Storage::disk('public')
            ->putFile('users', $request->file('image'));

        $user->update([
            'image' => $path
        ]);

        $user->save();

        return response()->json(array(
            'message' => 'Update image user',
            'data' => $path
        ), Response::HTTP_OK);
    }
}
