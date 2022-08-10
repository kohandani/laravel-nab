<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use App\Models\Image;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ImageController extends ApiController
{
    use Uploader;

    public function index()
    {
        //
    }


    public function store($shop_id,$shop_slug,$banners,$top_image,$mid_image,$bot_right_image,$bot_left_image,$other_images)
    {
        foreach ($banners as $banner) {
            $image = $this->uploadFile($banner,env("SHOP_IMAGE_PATH"),$shop_slug."/banners");
            Image::create([
                "shop_id" => $shop_id,
                "type" => "banner",
                "position" => NULL,
                "image_name" => $image,
                "image_alt" => $shop_slug." banner",
            ]);
        }

        $image = $this->uploadFile($top_image[0],env("SHOP_IMAGE_PATH"),$shop_slug."/images");
        Image::create([
            "shop_id" => $shop_id,
            "type" => "normal", 
            "position" => "top",
            "image_name" => $image,
            "image_alt" => $shop_slug." image",
        ]);

        $image = $this->uploadFile($mid_image[0],env("SHOP_IMAGE_PATH"),$shop_slug."/images");
        Image::create([
            "shop_id" => $shop_id,
            "type" => "normal",
            "position" => "mid",
            "image_name" => $image,
            "image_alt" => $shop_slug." image",
        ]);

        $image = $this->uploadFile($bot_right_image[0],env("SHOP_IMAGE_PATH"),$shop_slug."/images");
        Image::create([
            "shop_id" => $shop_id,
            "type" => "normal",
            "position" => "bot_right",
            "image_name" => $image,
            "image_alt" => $shop_slug." image",
        ]);

        $image = $this->uploadFile($bot_left_image[0],env("SHOP_IMAGE_PATH"),$shop_slug."/images");
        Image::create([
            "shop_id" => $shop_id,
            "type" => "normal",
            "position" => "bot_left",
            "image_name" => $image,
            "image_alt" => $shop_slug." image",
        ]);

        if($other_images !== NULL){
            foreach ($other_images as $item) {
                $image = $this->uploadFile($item,env("SHOP_IMAGE_PATH"),$shop_slug."/images");
                Image::create([
                    "shop_id" => $shop_id,
                    "type" => NULL,
                    "position" => NULL,
                    "image_name" => $image,
                    "image_alt" => $shop_slug." image",
                ]);
            }
        }
    }


    public function show($id)
    {
        //
    }


    public function update($shop_id,$shop_slug,$banners,$top_image,$mid_image,$bot_right_image,$bot_left_image,$other_images)
    {
        if($banners !== NULL){
            foreach ($banners as $banner) {
                $image = $this->uploadFile($banner,env("SHOP_IMAGE_PATH"),$shop_slug."/banners");
                Image::create([
                    "shop_id" => $shop_id,
                    "type" => "banner",
                    "position" => NULL,
                    "image_name" => $image,
                    "image_alt" => $shop_slug." banner",
                ]);
            }
        }

        if($top_image !== NULL){
            $shop = Shop::find($shop_id);
            $shop->images->where("position","top")->first()->update([
                "position" => NULL,
                "type" => NULL,
            ]);

            $image = $this->uploadFile($top_image[0],env("SHOP_IMAGE_PATH"),$shop_slug."/images");
            Image::create([
                "shop_id" => $shop_id,
                "type" => "normal",
                "position" => "top",
                "image_name" => $image,
                "image_alt" => $shop_slug." image",
            ]);
        }

        if($mid_image !== NULL){
            $shop = Shop::find($shop_id);
            $shop->images->where("position","mid")->first()->update([
                "position" => NULL,
                "type" => NULL,
            ]);

            $image = $this->uploadFile($mid_image[0],env("SHOP_IMAGE_PATH"),$shop_slug."/images");
            Image::create([
                "shop_id" => $shop_id,
                "type" => "normal",
                "position" => "mid",
                "image_name" => $image,
                "image_alt" => $shop_slug." image",
            ]);
        }


        if($bot_right_image !== NULL){
            $shop = Shop::find($shop_id);
            $shop->images->where("position","bot_right")->first()->update([
                "position" => NULL,
                "type" => NULL,
            ]);

            $image = $this->uploadFile($bot_right_image[0],env("SHOP_IMAGE_PATH"),$shop_slug."/images");
            Image::create([
                "shop_id" => $shop_id,
                "type" => "normal",
                "position" => "bot_right",
                "image_name" => $image,
                "image_alt" => $shop_slug." image",
            ]);
        }


        if($bot_left_image !== NULL){
            $shop = Shop::find($shop_id);
            $shop->images->where("position","bot_left")->first()->update([
                "position" => NULL,
                "type" => NULL,
            ]);

            $image = $this->uploadFile($bot_left_image[0],env("SHOP_IMAGE_PATH"),$shop_slug."/images");
            Image::create([
                "shop_id" => $shop_id,
                "type" => "normal",
                "position" => "bot_left",
                "image_name" => $image,
                "image_alt" => $shop_slug." image",
            ]);
        }


        if($other_images !== NULL){
            foreach ($other_images as $item) {
                $image = $this->uploadFile($item,env("SHOP_IMAGE_PATH"),$shop_slug."/images");
                Image::create([
                    "shop_id" => $shop_id,
                    "type" => NULL,
                    "position" => NULL,
                    "image_name" => $image,
                    "image_alt" => $shop_slug." image",
                ]);
            }
        }
    }


    public function altUpdate(Shop $shop)
    {
        foreach ($shop->images as $image) {
            if($image->type == "banner"){
                $image->update([
                    "image_alt" => $shop->slug." banner"
                ]);
            }else{
                $image->update([
                    "image_alt" => $shop->slug." image"
                ]);
            }
        }
    }

    public function destroy($id)
    {
        //
    }
}
