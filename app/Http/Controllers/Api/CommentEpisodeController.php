<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentEpisodeResource;
use App\Models\CommentEpisode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentEpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $commentEpisode = CommentEpisode::get();
        return CommentEpisodeResource::collection($commentEpisode);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $commentEpisode = new CommentEpisode();
        $commentEpisode->message = $request->get('message');
        $commentEpisode->episode_id = $request->get('episode_id');
        $commentEpisode->user_id = $request->get('user_id');


        if ($commentEpisode->save()) {

            return response()->json([
                'success' => true,
                'message' => 'Comment created with id ' . $commentEpisode->id,
                '$commentNovel_id' => $commentEpisode->id
            ], Response::HTTP_CREATED);

        }

        return response()->json([
            'success' => false,
            'message' => 'Comment creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommentEpisode $commentEpisode
     * @return CommentEpisodeResource
     */
    public function show(CommentEpisode $commentEpisode)
    {
        return new CommentEpisodeResource($commentEpisode);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommentEpisode $commentEpisode
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CommentEpisode $commentEpisode)
    {
        if($request->has('message')) $commentEpisode->message = $request->get('message');

        if ($commentEpisode->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment updated with id ' . $commentEpisode->id,
                'reward_id' => $commentEpisode->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Comment update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCommentEpisode($id) {

        $comment = CommentEpisode::where('episode_id', $id)->get();
        return CommentEpisodeResource::collection($comment);
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
