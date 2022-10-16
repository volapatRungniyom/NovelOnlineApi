<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RewardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'detail' => $this->detail,
            'total_amount' => $this->total_amount,
            'balance' => $this->balance,
            'expired_at' => $this->expired_at,
            'point' => $this->point,
            'codes' => RewardCodeResource::collection($this->whenLoaded('rewardCodes'))
        ];
    }
}
