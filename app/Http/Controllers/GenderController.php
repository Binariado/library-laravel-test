<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenderRequest;
use App\Http\Requests\UpdateGenderRequest;
use App\Models\Gender;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            "message" => "List genders",
            "data" => Gender::all()
        ], Response::HTTP_CREATED);
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
     * @param  StoreGenderRequest  $request
     * @return JsonResponse
     */
    public function store(StoreGenderRequest $request): JsonResponse
    {
        $gender = new Gender([
            "name" => $request->get('name')
        ]);

        $gender->save();

        return response()->json([
            "message" => "gender created",
            "data" => $gender
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Gender  $gender
     * @return JsonResponse
     */
    public function show(Gender $gender): JsonResponse
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function edit(Gender $gender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateGenderRequest  $request
     * @param  Gender  $gender
     * @return JsonResponse
     */
    public function update(UpdateGenderRequest $request, Gender $gender): JsonResponse
    {
        $gender->update([
            'name' => $request->get('name')
        ]);

        $gender->save();

        return response()->json([
            "message" => "Gender updated",
            "data" => $gender
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Gender  $gender
     * @return JsonResponse
     */
    public function destroy(Gender $gender): JsonResponse
    {
        $gender->delete();

        return response()->json([
            "message" => "Gender deleted",
            "data" => $gender
        ], Response::HTTP_OK);
    }
}
