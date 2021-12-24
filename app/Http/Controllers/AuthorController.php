<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            "message" => "list authors",
            "data" => Author::all()
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAuthorRequest  $request
     * @return JsonResponse
     */
    public function store(StoreAuthorRequest $request): JsonResponse
    {

        $author = new Author([
            "name" => $request->get('name')
        ]);

        $author->save();

        return response()->json([
            "message" => "author created",
            "data" => $author
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Author  $author
     * @return JsonResponse
     */
    public function show(Author $author): JsonResponse
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Author  $author
     * @return JsonResponse
     */
    public function edit(Author $author): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAuthorRequest  $request
     * @param  Author  $author
     * @return JsonResponse
     */
    public function update(UpdateAuthorRequest $request, Author $author): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Author  $author
     * @return JsonResponse
     */
    public function destroy(Author $author): JsonResponse
    {
        //
    }
}
