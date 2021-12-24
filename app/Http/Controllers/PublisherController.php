<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(array(
            'message' => 'List publisher',
            'data' => Publisher::all(),
        ), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePublisherRequest $request
     * @return JsonResponse
     */
    public function store(StorePublisherRequest $request): JsonResponse
    {
        $publisher = new Publisher([
            "name" => $request->get('name')
        ]);

        $publisher->save();

        return response()->json([
            "message" => "publisher created",
            "data" => $publisher
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Publisher  $publisher
     * @return JsonResponse
     */
    public function show(Publisher $publisher): JsonResponse
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Publisher  $publisher
     * @return JsonResponse
     */
    public function edit(Publisher $publisher): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePublisherRequest  $request
     * @param  Publisher  $publisher
     * @return JsonResponse
     */
    public function update(UpdatePublisherRequest $request, Publisher $publisher): JsonResponse
    {
        $publisher->update([
            'name' => $request->get('name')
        ]);

        $publisher->save();

        return response()->json([
            "message" => "publisher updated",
            "data" => $publisher
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Publisher  $publisher
     * @return JsonResponse
     */
    public function destroy(Publisher $publisher): JsonResponse
    {
        $publisher->delete();

        return response()->json([
            "message" => "publisher deleted",
            "data" => $publisher
        ], Response::HTTP_OK);
    }
}
