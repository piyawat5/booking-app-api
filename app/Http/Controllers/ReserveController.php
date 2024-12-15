<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReserveController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'page' => 'required',
            'size' => 'required',
        ]);

        $query = Reserve::with(['rooms', 'configs', 'roomMembers.users.userDetails', 'reserver']);

        // กรองข้อมูลตาม query parameters
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->query('title') . '%');
        }
        if ($request->has('room')) {
            $query->whereHas('rooms', function ($q) use ($request) {
                $q->where('id', $request->query('room'));
            });
        }

        if ($request->has('roomMembersId')) {
            $query->whereHas('roomMembers', function ($q) use ($request) {
                $q->where('user_id', $request->query('roomMembersId'));
            });
        }
        if ($request->has('reserveId')) {
            $query->where('id', $request->query('reserveId'));
        }
        if ($request->has('startDate')) {
            $query->where('start_date', '>=', $request->query('startDate'));
        }
        if ($request->has('endDate')) {
            $query->where('end_date', '<=', $request->query('endDate'));
        }
        if ($request->has('timeStart')) {
            $query->where('start_time', '>=', $request->query('timeStart'));
        }
        if ($request->has('timeEnd')) {
            $query->where('end_time', '<=', $request->query('timeEnd'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }
        if ($request->has('userId')) {
            $query->where('reserver', $request->query('userId'))->get();
        }

        //category tab
        $categoryQuery = clone $query;
        $allRoom = $categoryQuery->count();
        $smallRoom = $categoryQuery->whereHas('rooms', function ($q) {
            $q->where('category_id', 1);
        })->count();
        $mediumRoom = $categoryQuery->whereHas('rooms', function ($q) {
            $q->where('category_id', 2);
        })->count();
        $auditorium = $categoryQuery->whereHas('rooms', function ($q) {
            $q->where('category_id', 3);
        })->count();

        if ($request->has('categoryId')) {
            $query->whereHas('rooms', function ($q) use ($request) {
                $q->where('category_id', $request->query('categoryId'));
            });
        }

        // Pagination
        $page = $request->query('page', 1);
        $size = $request->query('size', 25);

        // Calculate skip value
        $skip = ($page - 1) * $size;

        // Count total records after filtering
        $totalRecords = $query->count();

        // Get paginated results
        $res = $query->orderByDesc('reserves.id')
            ->skip($skip)
            ->take($size)
            ->get()
            ->makeHidden(['rooms']);

        return response([
            'status' => true,
            'message' => 'ok',
            'count' => $totalRecords,
            'allRoom' => $allRoom,
            'smallRoom' => $smallRoom,
            'mediumRoom' => $mediumRoom,
            'auditorium' => $auditorium,
            'reserve' => $res->map(function ($reserve) {
                return array_merge(
                    $reserve->toArray(),
                    [
                        'room' => $reserve->rooms,
                        // 'configs' => $reserve->configs,
                    ]
                );
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // if ($user->tokenCan('1')) {
        $field = $request->validate([
            'room_id' => 'integer|required',
            'reserver' => 'integer|required',
            'title' => 'string|required',
            'description' => 'nullable|string',
            'start_date' => 'date|required',
            'end_date' => 'date|required|after_or_equal:start_date',
            'start_time' => 'date_format:H:i|required',
            'end_time' => 'date_format:H:i|required',
            'prepare' => 'nullable|string',
            // 'status' => 'integer|required',
            // 'users_amount' => 'integer|required',
        ]);
        // }

        $reserve = Reserve::create([
            'room_id' => $field['room_id'],
            'reserver' => $field['reserver'],
            'title' => $field['title'],
            'description' => $field['description'],
            'start_date' => $field['start_date'],
            'end_date' => $field['end_date'],
            'start_time' => $field['start_time'],
            'end_time' => $field['end_time'],
            'prepare' => $field['prepare'],
            'status' => "0",
            'users_amount' => "0",
        ]);


        return response([
            'status' => true,
            'message' => 'ok',
            'reserve' => $reserve
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $res = Reserve::with(['rooms', 'configs', 'roomMembers.users.userDetails', 'reserver'])->find($id);

        return response(['data' => $res]);
    }

    public function getAllMyReserver(Request $request, $user_id)
    {
        $res = Reserve::with(['rooms', 'configs', 'roomMembers', 'reserver'])->where('reserver', $user_id)->get();

        return response(['data' => $res]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Reserve $reserve)
    {

        $field = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'reserver' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'prepare' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'users_amount' => 'nullable|integer',

        ]);


        $reserve->update($field);
        return response([
            'data' => $reserve
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserve $reserve)
    {
        //
    }
}
