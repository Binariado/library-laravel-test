<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\UpdateLibraryRequest;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        $libraries = Library::all();

        return response()->json([
            "message" => "List libraries",
            "data" => $libraries
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
            $path = Storage::disk('public')
                ->putFile('libraries', $request->file('image'));
        }

        $gender = new Library([
            "name" => $request->get('name'),
            "book_archive" => $request->get('book_archive'),
            "author_id" => $request->get('author_id'),
            "editor_id" => $request->get('editor_id'),
            "publisher_id" => $request->get('publisher_id'),
            "gender" => $request->get('gender'),
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


        $library->update([
            "name" => $request->get('name'),
            "book_archive" => $request->get('book_archive'),
            "author_id" => $request->get('author_id'),
            "editor_id" => $request->get('editor_id'),
            "publisher_id" => $request->get('publisher_id'),
            "gender" => $request->get('gender'),
            "language_id" => $request->get('language_id'),
            "date_of_publication" => $request->get('date_of_publication'),
            "number_page" => $request->get('number_page')
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

    /**
     * @param Request $request
     * @param Library $library
     * @return JsonResponse
     */
    public function image(Request $request, Library $library): JsonResponse{

        $validator = Validator::make($request->all(), [
            'image' => ['required', '']
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        if ( Storage::disk('public')->exists($library->image)) {
            Storage::disk('public')
                ->delete($library->image);
        }

        $path = Storage::disk('public')
            ->putFile('libraries', $request->file('image'));


        $library->update([
            'image' => $path
        ]);

        $library->save();

        return response()->json(array(
            'message' => 'Update image user',
            'data' => $path
        ), Response::HTTP_OK);
    }
}
