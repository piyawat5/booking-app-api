<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request)
    {

        // Validate field
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|confirmed',
            'email' => 'required|string|unique:users,email',
            'position' => 'required|string',
            'address' => 'string',
            'birth' => 'required|string',
            'role' => 'required|integer',
            'tel' => 'required|string',
            'image' => 'string',
        ]);

        // Create user
        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'username' => $fields['username'],
            'email' => $fields['email'],
            'position' => $fields['position'],
            'address' => $fields['address'],
            'birth' => $fields['birth'],
            'password' => bcrypt($fields['password']),
            'tel' => $fields['tel'],
            'role' => $fields['role']
        ]);

        // Create user detail
        $userDetail = UserDetail::create([
            'user_id' => $user->id,
            'avatar_head' => null,
            'avatar_hair' => null,
            'avatar_face' => null,
            'avatar_skin' => null,
            'avatar_shirt' => null,
            'avatar_back' => null,
        ]);

        $response = [
            'status' => true,
            'message' => "User registered successfully",
            'user' => array_merge(
                $user->toArray(),
                ['userDetail' => $userDetail->toArray()]
            ),
        ];

        return response($response, 201);
    }

    // Login User
    public function login(Request $request)
    {

        // Validate field
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'status' => false,
                'message' => 'Login failed'
            ], 401);
        } else {

            // ลบ token เก่าออกแล้วค่อยสร้างใหม่
            $user->tokens()->delete();

            // Create token
            $token = $user->createToken($request->userAgent(), ["$user->role"])->plainTextToken;

            $response = [
                'status' => true,
                'message' => 'Login successfully',
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);
        }
    }
    // Refresh Token
    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken($request->userAgent(), ["$user->role"])->plainTextToken;
        $response = [
            'status' => true,
            'message' => 'Token refreshed',
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    // Logout User
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        //TODO: check this
        // auth()->user()->tokens()->delete();
        return [
            'status' => true,
            'message' => 'Logged out'
        ];
    }

    //verify
    public function verify(Request $request)
    {
        $user = $request->user();
        return response(
            [
                'status' => true,
                'message' => 'verify success',
                'user' => $user
            ]
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = User::all();

        return response([
            'data' => $res
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $userById = User::with('userDetails')->find($id);

        return response([
            'data' => $userById
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $userById) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $userById)
    {
        $userById->delete();

        return response()->json(null, 204);
    }
}
