<?php

namespace App\Http\Controllers;

use App\Models\RoomMember;
use Illuminate\Http\Request;

class RoomMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $res = RoomMember::with(['reserves', 'users'])->get();
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
            'reserve_id' => 'required|integer',
            'user_id' => 'required|integer',
            'seat' => 'required|string'
        ]);

        $res = RoomMember::create([
            'reserve_id' => $field['reserve_id'],
            'user_id' => $field['user_id'],
            'seat' => $field['seat']
        ]);

        return response(['data' => $res]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomMember $roomMember, $id) {}

    public function getAllMySeat(Request $request, $user_id)
    {

        $res = RoomMember::with(['reserves.rooms.categories'])->where('user_id', $user_id)->get();

        return response(
            ['data' => $res]
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomMember $roomMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomMember $roomMember)
    {
        //
    }
}
