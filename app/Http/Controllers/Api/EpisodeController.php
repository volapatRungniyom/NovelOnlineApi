<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EpisodeResource;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $episode = Episode::get();
        return EpisodeResource::collection($episode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $episode = new Episode();
        $episode->name = $request->get('name');
        $episode->detail = $request->get('detail') ?? null;
        $episode->novel_id = $request->get('novel_id');

        if ($episode->save()) {

            return response()->json([
                'success' => true,
                'message' => 'Episode created with id ' . $episode->id,
                'episode_id' => $episode->id
            ], Response::HTTP_CREATED);

        }

        return response()->json([
            'success' => false,
            'message' => 'Episode creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Episode $episode
     * @return EpisodeResource
     */
    public function show(Episode $episode)
    {
        return new EpisodeResource($episode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,Episode $episode)
    {
        if($request->has('name')) $episode->name = $request->get('name');
        if($request->has('detail')) $episode->detail = $request->get('detail');
        if($request->has('user_id')){
            if (!$episode->usersAll()->where('user_id',$request->get('user_id'))->exists()){
                $episode->users()->attach($request->get('user_id'));
            }

        }




        if ($episode->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Episode updated with id ' . $episode->id,
                'reward_id' => $episode->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Episode update failed'
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
