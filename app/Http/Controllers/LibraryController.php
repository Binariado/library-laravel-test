<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\UpdateLibraryRequest;
use App\Models\Library;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            "message" => "List libraries",
            "data" => Library::all()
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
     * @param  StoreLibraryRequest  $request
     * @return JsonResponse
     */
    public function store(StoreLibraryRequest $request): JsonResponse
    {

        $path = null;

        if ($request->file('image')) {
            $path = $request->file('image')->store('public/libraries');
        }

        $gender = new Library([
            "name" => $request->get('name'),
            "book_archive" => $request->get('book_archive'),
            "author_id" => $request->get('author_id'),
            "editor_id" => $request->get('editor_id'),
            "publisher_id" => $request->get('publisher_id'),
            "gender_id" => $request->get('gender_id'),
            "language_id" => $request->get('language_id'),
            "date_of_publication" => $request->get('date_of_publication'),
            "number_page" => $request->get('number_page'),
            "image" => $path
        ]);


        $gender->save();

        return response()->json([
            "message" => "Library created",
            "data" => $gender
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show(Library $library)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit(Library $library)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLibraryRequest  $request
     * @param  Library  $library
     * @return JsonResponse
     */
    public function update(UpdateLibraryRequest $request, Library $library): JsonResponse
    {
        $path = null;

        if ($request->file('image')) {

            if ($library->get('image')) {
                Storage::delete($library->get('image'));
            }

            $path = $request->file('image')->store('public/libraries');
        }

        $library->update([
            "name" => $request->get('name'),
            "book_archive" => $request->get('book_archive'),
            "author_id" => $request->get('author_id'),
            "editor_id" => $request->get('editor_id'),
            "publisher_id" => $request->get('publisher_id'),
            "gender_id" => $request->get('gender_id'),
            "language_id" => $request->get('language_id'),
            "date_of_publication" => $request->get('date_of_publication'),
            "number_page" => $request->get('number_page'),
            "image" => $path
        ]);

        $library->save();

        return response()->json([
            "message" => "Library updated",
            "data" => $library
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Library  $library
     * @return JsonResponse
     */
    public function destroy(Library $library): JsonResponse
    {
        $library->delete();

        return response()->json([
            "message" => "Library deleted",
            "data" => $library
        ], Response::HTTP_OK);
    }
}
