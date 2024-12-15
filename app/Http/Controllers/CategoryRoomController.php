<?php

namespace App\Http\Controllers;

use App\Models\CategoryRoom;
use Illuminate\Http\Request;

class CategoryRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = CategoryRoom::all();

        return response([
            'data' => $res
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $field = $request->validate([
            'category_name' => '',
            'description' => '',
            'capacity' => ''
        ]);

        $res = CategoryRoom::create([
            'category_name' => $field['category_name'],
            'description' => $field['description'],
            'capacity' => $field['capacity']
        ]);

        return response([
            'data' => $res
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryRoom $categoryRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryRoom $categoryRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryRoom $categoryRoom)
    {
        //
    }
}
