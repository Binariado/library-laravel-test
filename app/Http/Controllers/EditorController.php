<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEditorRequest;
use App\Http\Requests\UpdateEditorRequest;
use App\Models\Editor;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            "message" => "List editors",
            "data" => Editor::all()
        ], Response::HTTP_CREATED);
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
     * @param  StoreEditorRequest  $request
     * @return JsonResponse
     */
    public function store(StoreEditorRequest $request): JsonResponse
    {
        $editor = new Editor([
            "name" => $request->get('name')
        ]);

        $editor->save();

        return response()->json([
            "message" => "editor created",
            "data" => $editor
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Editor  $editor
     * @return JsonResponse
     */
    public function show(Editor $editor): JsonResponse
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Editor  $editor
     * @return JsonResponse
     */
    public function edit(Editor $editor): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEditorRequest  $request
     * @param  Editor  $editor
     * @return JsonResponse
     */
    public function update(UpdateEditorRequest $request, Editor $editor): JsonResponse
    {
        $editor->update([
            'name' => $request->get('name')
        ]);

        $editor->save();

        return response()->json([
            "message" => "editor updated",
            "data" => $editor
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Editor  $editor
     * @return JsonResponse
     */
    public function destroy(Editor $editor): JsonResponse
    {
        $editor->delete();

        return response()->json([
            "message" => "editor deleted",
            "data" => $editor
        ], Response::HTTP_OK);
    }
}
