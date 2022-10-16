<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = User::get();
        return UserResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->point = $request->get('point');
        $user->password = Hash::make($request->get('password'));
        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'User created with id ' . $user->id,
                'reward_id' => $user->id
            ], Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'User creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,User $user)
    {
        if($request->has('name')) $user->name = $request->get('name');
        if($request->has('email')) $user->email = $request->get('email');
        if($request->has('point')) $user->point = $request->get('point');
        if($request->has('image_path')) $user->image_path = $request->get('image_path') ?? null;
        if($request->has('password')) $user->password = $request->get('password');
        if($request->has('password')) $user->password = $request->get('password');
        if($request->has('novel_id')) $user->novels()->attach($request->get('novel_id'));


        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated with id ' . $user->id,
                'reward_id' => $user->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'User update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
