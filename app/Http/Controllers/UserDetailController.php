<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Http\Request;

class UserDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $user_id)
    {
        $userDetail = UserDetail::with(['users'])->where('user_id', $user_id)->first();
        return response([
            'status' => true,
            'userDetail' => $userDetail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserDetail $userDetail)
    {

        $field = $request->validate([
            'avatar_head' => 'nullable|string',
            'avatar_hair' => 'nullable|string',
            'avatar_face' => 'nullable|string',
            'avatar_skin' => 'nullable|string',
            'avatar_shirt' => 'nullable|string',
            'avatar_back' => 'nullable|string'
        ]);
        $userDetail->update($field);
        return response([
            'status' => true,
            'message' => 'ok',
            'userDetail' => $userDetail,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserDetail $userDetail)
    {
        //
    }
}
