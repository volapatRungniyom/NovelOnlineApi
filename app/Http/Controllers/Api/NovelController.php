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
        $novel->name = $request->get('name') ?? null;
        $novel->detail = $request->get('detail') ?? null;
        //$novel->detail = $request->get('detail') ?? null;

        if ($request->hasFile('image')){
            $destination_path = 'public/image';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path,$image_name);
            $novel->image = $image_name;
        }

//        if ($request->has('image')) {
//            $this->validate($request,[
//                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
//            ]);
//            $image_path = $request->file('image')->store('image', 'public');
//            $novel->image = $image_path;
//            $novel->save();
//        }

        if ($novel->save()) {

            $novel->users()->attach($request->get('user_id'),['is_owner' => 1]);
            $novel->save();
            return response()->json([
                'success' => true,
                'message' => 'Novel created with id ' . $novel->id,
                'novel_id' => $novel->id
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
        //$novel = Novel::find($novel->id);
        if($request->has('name')) $novel->name = $request->get('name');
        if($request->has('detail')) $novel->detail = $request->get('detail');

        if($request->has('user_id')){
            if ($novel->users()->where('user_id',$request->get('user_id'))
                ->where('is_owner',1)->where('is_active',1)->exists()){
                $novel->usersActive()->updateExistingPivot($request->get('user_id'),['is_active' => 0]);
                //$novel->users()->detach($request->get('user_id'));
                //$novel->users()->attach($request->get('user_id'),['is_active' => 0]);
            }
            elseif ($novel->users()->where('user_id',$request->get('user_id'))
                ->where('is_owner',1)->where('is_active',0)->exists()){
                $novel->usersActive()->updateExistingPivot($request->get('user_id'),['is_active' => 1]);
                //$novel->users()->detach($request->get('user_id'));
                //$novel->users()->attach($request->get('user_id'),['is_active' => 1]);
            }
            elseif ($novel->users()->where('user_id',$request->get('user_id'))
                ->where('is_owner',false)->exists()){
                $novel->users()->detach($request->get('user_id'));
            }
            else {
                $novel->users()->attach($request->get('user_id'),['is_active' => 1]);
            }
        }

        if ($request->hasFile('image')){
            $destination_path = 'public/image';

            if($novel->image != ''  && $novel->image != null){
                $file_old = $novel->image;
                unlink('storage/public/image/fa4.png');
            }

            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path,$image_name);
            $novel->image = $image_name;
            $novel->update(['image' => $image_name]);
        }


        if ($novel->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Novel updated with id ' . $novel->id,
                'Novel_id' => $novel->id,
                'Image' => $novel->image,
                'test' => $novel->name
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Novel update failed'
        ], Response::HTTP_BAD_REQUEST);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function NovelEdit(Request $request, $id)
    {
        $novel = Novel::find($id);
        if ($request->hasFile('image')){
            $destination_path = 'public/image';
            $image = $request->file('image');
            $image_name = $image->hashName();
            $path = $request->file('image')->storeAs($destination_path,$image_name);
            $novel->image = $image_name;
        }
        if($request->has('name')) $novel->name = $request->get('name');
        if($request->has('detail')) $novel->detail = $request->get('detail');


        if ($novel->save()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated with id ' . $novel->id,
                'reward_id' => $novel->id
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
