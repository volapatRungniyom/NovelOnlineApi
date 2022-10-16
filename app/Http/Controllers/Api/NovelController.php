<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NovelResource;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NovelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $novels = Novel::get();
        return NovelResource::collection($novels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $novel = new Novel();
        $novel->name = $request->get('name');
        $novel->detail = $request->get('detail') ?? null;

        if ($novel->save()) {
            $novel->users()->attach($request->get('user_id'),['is_owner' => 1]);
            $novel->save();
            return response()->json([
                'success' => true,
                'message' => 'Novel created with id ' . $novel->id,
                'reward_id' => $novel->id
            ], Response::HTTP_CREATED);

        }

        return response()->json([
            'success' => false,
            'message' => 'Reward creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Novel $novel
     * @return NovelResource
     */
    public function show(Novel $novel)
    {
        return new NovelResource($novel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Novel  $novel
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,Novel $novel)
    {
        if($request->has('name')) $novel->name = $request->get('name');
        if($request->has('detail')) $novel->detail = $request->get('detail');
        if($request->has('user_id')) $novel->users()->attach($request->get('user_id'));

        if ($novel->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Novel updated with id ' . $novel->id,
                'reward_id' => $novel->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Novel update failed'
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
