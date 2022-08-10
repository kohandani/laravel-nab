<?php

namespace App\Http\Resources;

use App\Http\Resources\ImageResource;
use App\Http\Resources\PhoneResource;
use App\Http\Resources\SocialResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $banners = [];
        foreach (ImageResource::collection($this->whenloaded("images"))->where("type","banner") as $banner) {
            array_push($banners,$banner);
        }

        return [
            "shop_id" => $this->id,
            "guild_id"=>$this->guild_id,
            "name" => $this->name,
            "shop_slug" => $this->slug,
            "email" => $this->email,
            "video_name" => $this->video,
            "address" => $this->address,
            "website" => $this->website,
            "license" => $this->license,
            "page_link" => $this->page_link,
            "top_box_title" => $this->top_box_title,
            "top_box_body" => $this->top_box_body,
            "mid_box_title" => $this->mid_box_title,
            "mid_box_body" => $this->mid_box_body,
            "bot_box_title" => $this->bot_box_title,
            "bot_box_body" => $this->bot_box_body,
            "show_status" => $this->show_status,
            "stablished_at" => $this->stablished_at,
            "images" => [
                "banners" => $banners,
                "top_image" => ImageResource::collection($this->whenloaded("images"))->where("position","top")->first(),
                "mid_image" => ImageResource::collection($this->whenloaded("images"))->where("position","mid")->first(),
                "bot_right_image" => ImageResource::collection($this->whenloaded("images"))->where("position","bot_right")->first(),
                "bot_left_image" => ImageResource::collection($this->whenloaded("images"))->where("position","bot_left")->first(),
                "album" => ImageResource::collection($this->whenloaded("images")),
            ],
            "phones" => PhoneResource::collection($this->whenloaded("phones")) ,
            "social_medias" => SocialResource::collection($this->whenloaded("socials")) ,
            "source_files_address" => [
                "banners" => public_path(env("SHOP_IMAGE_PATH"))."/$this->slug"."/banners/",
                "images" => public_path(env("SHOP_IMAGE_PATH"))."/$this->slug"."/images/",
                "video" => public_path(env("SHOP_VIDEO_PATH"))."/$this->slug/",
            ],
        ];
    }
}
