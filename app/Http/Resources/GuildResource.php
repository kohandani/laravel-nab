<?php

namespace App\Http\Resources;

use App\Http\Resources\ShopResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GuildResource extends JsonResource
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
            "guild_slug" => $this->slug ,
            "image_src" => env("GUILD_IMAGE_PATH")."/$this->slug/".$this->image ,
            "show_status" => $this->show_status ,
            "shops" => ShopResource::collection($this->whenloaded("shops")) ,
        ];
    }
}
