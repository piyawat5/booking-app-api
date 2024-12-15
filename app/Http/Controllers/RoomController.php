<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $res = Room::all();

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
            'category_id' => 'integer|required',
            'room_name' => 'required|unique:rooms'
        ]);

        $res = Room::create([
            'category_id' => $field['category_id'],
            'room_name' => $field['room_name']
        ]);

        return response([
            'data' => $res
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $res = Room::with(['reserves', 'categories'])->find($id);
        return response(
            ['data' => $res]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }

    public function findRoomAuto(Request $request)
    {
        $query = Room::with(['reserves', 'categories']);
        if ($request->has('categoryId')) {
            $query->where('category_id', $request->query('categoryId'));
        }

        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $startTime = $request->query('startTime');
        $endTime = $request->query('endTime');

        // Filter rooms that do not have reservations overlapping with the requested dates and times
        if ($startDate && $endDate && $startTime && $endTime) {
            $query->whereDoesntHave('reserves', function ($q) use ($startDate, $endDate, $startTime, $endTime) {
                $q->where(function ($query) use ($startDate, $endDate, $startTime, $endTime) {
                    // Overlap if reservation starts before endDate and ends after startDate
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                $query->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                            });
                    });

                    // Add time filters only if both startTime and endTime are provided
                    if ($startTime && $endTime) {
                        $query->where(function ($query) use ($startTime, $endTime) {
                            $query->whereBetween('start_time', [$startTime, $endTime])
                                ->orWhereBetween('end_time', [$startTime, $endTime])
                                ->orWhere(function ($query) use ($startTime, $endTime) {
                                    $query->where('start_time', '<=', $startTime)
                                        ->where('end_time', '>=', $endTime);
                                });
                        });
                    }
                });
            });
        }


        // ดึงข้อมูลห้องว่างตามเงื่อนไขที่ตั้งไว้
        $availableRooms = $query->first();

        return response([
            'data' => $availableRooms
        ]);
    }
}
