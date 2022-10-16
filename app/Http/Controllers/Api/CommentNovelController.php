<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentNovelResource;
use App\Models\CommentNovel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentNovelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $comment = CommentNovel::get();
        return CommentNovelResource::collection($comment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $comment = new CommentNovel();
        $comment->message = $request->get('message');
        $comment->novel_id = $request->get('novel_id');

        if ($comment->save()) {

            return response()->json([
                'success' => true,
                'message' => 'Comment created with id ' . $comment->id,
                '$commentNovel_id' => $comment->id
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
     * @param  \App\Models\CommentNovel $commentNovel
     * @return CommentNovelResource
     */
    public function show(CommentNovel $commentNovel)
    {
        return new CommentNovelResource($commentNovel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommentNovel $commentNovel
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CommentNovel $commentNovel)
    {
        if($request->has('message')) $commentNovel->message = $request->get('message');

        if ($commentNovel->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment updated with id ' . $commentNovel->id,
                'reward_id' => $commentNovel->id
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
    public function destroy($id)
    {
        //
    }

}
