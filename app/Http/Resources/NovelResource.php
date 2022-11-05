<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NovelResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'detail' => $this->detail,
            'image' => $this->image,
            'episodes' => $this->episodes,
            'episodesCreated' => $this->episodesCreated,
            'comments' => $this->comments,
            'tags' => $this->tags,
            'user' => $this->users,
            'view' => $this->view
        ];
    }
}
