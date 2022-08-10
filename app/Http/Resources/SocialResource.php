<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
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
            "id" => $this->id ,
            "name" => $this->name ,
            "icon" => $this->icon ,
            "link" => $this->whenPivotLoaded("shop_social",function(){
                return $this->pivot->link;
            }) ,
        ];
    }
}
