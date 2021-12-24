<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignRoleRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(array(
            'message' => 'List roles',
            'data' => Role::all()
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
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(array(
            'message' => 'Show role',
            'data' => Role::findById($id)
        ), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param StoreAssignRoleRequest $request
     * @return JsonResponse
     */
    public function assign(StoreAssignRoleRequest $request): JsonResponse
    {
        $role = Role::findById($request->get('role_id'));
        $user = User::query()
            ->where('id', $request->get('user_id'))
            ->first();

        $user->assignRole($role);

        return response()->json(array(
            'message' => "Successful assignment of {$role->name} roles",
            'data' => $user
        ));
    }
}
