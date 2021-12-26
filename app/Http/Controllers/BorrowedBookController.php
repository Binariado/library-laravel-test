<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowedBookRequest;
use App\Http\Requests\UpdateBorrowedBookRequest;
use App\Models\BorrowedBook;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BorrowedBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $BorrowedBooks = BorrowedBook::all();

        foreach ($BorrowedBooks as $item) {
            $item->borrowedBookUsers;
        }

        return response()->json([
            "message" => "List borrowed book",
            "data" => $BorrowedBooks
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
     * @param  StoreBorrowedBookRequest  $request
     * @return JsonResponse
     */
    public function store(StoreBorrowedBookRequest $request): JsonResponse
    {
        $user = User::query()->find($request->get('user_id'));

        if ($user->banned) {
            return response()->json([
                "message" => "User banned",
                "data" => $user
            ], Response::HTTP_FORBIDDEN);
        }

        $delivery_date_delta =  date('Y-m-d H:i:s');

        $validator = Validator::make([
            'delivery_date' => $delivery_date_delta,
            'return_date' => $request->get('return_date')
        ], [
            'delivery_date' => 'required|date|after:start_date',
            'return_date' => 'required|date|after:tomorrow',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $gender = new BorrowedBook([
            "library_id" => $request->get('library_id'),
            "user_id" => $request->get('user_id'),
            'delivery_date' => $delivery_date_delta,
            "return_date" => $request->get('return_date')
        ]);

        $gender->save();

        return response()->json([
            "message" => "Borrowed book created",
            "data" => $gender
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BorrowedBook  $borrowedBook
     * @return \Illuminate\Http\Response
     */
    public function show(BorrowedBook $borrowedBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BorrowedBook  $borrowedBook
     * @return \Illuminate\Http\Response
     */
    public function edit(BorrowedBook $borrowedBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBorrowedBookRequest  $request
     * @param  BorrowedBook  $borrowedBook
     * @return JsonResponse
     */
    public function update(UpdateBorrowedBookRequest $request, BorrowedBook $borrowedBook): JsonResponse
    {
        $delivery_date_delta =  date('Y-m-d H:i:s');

        $validator = Validator::make([
            'delivery_date' => $delivery_date_delta,
            'return_date' => $request->get('return_date')
        ], [
            'delivery_date' => 'required|date|after:start_date',
            'return_date' => 'required|date|after:tomorrow',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $borrowedBook->update([
            "library_id" => $request->get('library_id'),
            "user_id" => $request->get('user_id'),
            'delivery_date' => $delivery_date_delta,
            "return_date" => $request->get('return_date')
        ]);

        $borrowedBook->save();

        return response()->json([
            "message" => "Borrowed book updated",
            "data" => $borrowedBook
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BorrowedBook  $borrowedBook
     * @return JsonResponse
     */
    public function destroy(BorrowedBook $borrowedBook): JsonResponse
    {
        $borrowedBook->delete();

        return response()->json([
            "message" => "Borrowed book deleted",
            "data" => $borrowedBook
        ], Response::HTTP_OK);
    }
}
