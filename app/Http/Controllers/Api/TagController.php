<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $tags = Tag::get();
        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $tag = new Tag();
        $tag->name = $request->get('name');
        if ($tag->save()) {

            return response()->json([
                'success' => true,
                'message' => 'Tag created with id ' . $tag->id,
                'Tag_id' => $tag->id
            ], Response::HTTP_CREATED);

        }

        return response()->json([
            'success' => false,
            'message' => 'Tag creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag $tag
     * @return TagResource
     */
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Tag $tag)
    {
        if($request->has('name')) $tag->name = $request->get('name');
        if($request->has('novel_id')) {
            if ($tag->novels()->where('novel_id',$request->get('novel_id'))->exists()){
                $tag->novels()->detach($request->get('novel_id'));

            }else{
                $tag->novels()->attach($request->get('novel_id'));
            }
        }

        if ($tag->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Tag updated with id ' . $tag->id,
                'reward_id' => $tag->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tag update failed'
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
