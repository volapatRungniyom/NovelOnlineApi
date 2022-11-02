<?php

namespace App\Http\Resources;

use App\Models\Episode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        //$prev = $this->resource::get();
        $prev = $this->resource::select('id')->where('id', '<', $this->resource->id)->where('novel_id',$this->resource->novel_id)->max('id');
        $next = $this->resource::select('id')->where('id', '>', $this->resource->id)->where('novel_id',$this->resource->novel_id)->min('id');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'detail' => $this->detail,
            'novel_id' => $this->novel_id,
            'comment' => $this->comments,
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d H:i:s'),
            'prev' => $prev,
            'next' => $next
        ];
    }
}
