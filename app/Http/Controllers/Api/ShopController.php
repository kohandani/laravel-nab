<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Shop;
use App\Models\Social;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ShopResource;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PhoneController;


class ShopController extends ApiController
{

    public function index()
    {
        $shops = Shop::all();
        return $this->yresp(ShopResource::collection($shops->load("socials")->load("images")->load("phones")),200);
    }


    public function store(Request $request)
    {


        $now = Jalalian::fromCarbon(Carbon::now())->getYear();
        $validator = Validator::make($request->all(),[
            // SHOP TABLE VALIDATIONS
            "guild_id" => "required|numeric",
            "name" => "required|string|unique:shops,name",
            "slug" => "required|string|unique:shops,slug",
            "email" => "required|email|unique:shops,email",
            "video" => "nullable|max:1",
            "video.*" => "nullable|mimes:mp4,mkv|max:4096",
            "address" => "required|string",
            "website" => "nullable",
            "license" => "nullable",
            "page_link" => "required|unique:shops,page_link",
            "top_box_title" => "required|string",
            "top_box_body" => "required|string",
            "mid_box_title" => "required|string",
            "mid_box_body" => "required|string",
            "bot_box_title" => "required|string",
            "bot_box_body" => "required|string",
            "stablished_at" => "required|numeric|max:$now",

            // SOCIAL TABLE VALIDATIONS => IN STORE METHOD OF SOCIALCONTROLLER
            "social_ids" => "required",
            "social_ids.*" => "numeric|distinct",
            "social_links" => "required",
            "social_links.*" => "string|distinct",

            // IMAGE TABLE VALIDATIONS
            "banners" => "required|min:3",
            "banners.*" => "image|mimes:png,jpg|max:1024",
            "top_image" => "required|max:1",
            "top_image.*" => "image|mimes:png,jpg|max:1024",
            "mid_image" => "required|max:1",
            "mid_image.*" => "image|mimes:png,jpg|max:1024",
            "bot_right_image" => "required|max:1",
            "bot_right_image.*" => "image|mimes:png,jpg|max:1024",
            "bot_left_image" => "required|max:1",
            "bot_left_image.*" => "image|mimes:png,jpg|max:1024",
            "other_images" => "nullable",
            "other_images.*" => "image|mimes:png,jpg|max:1024",

            // PHONE TABLE VALIDATIONS
            "phones" => "required|min:1",
            "phones.*" => "string|starts_with:0|max:11",
        ]);
        if($validator->fails()){
            return $this->nresp($validator->messages(),500);
        }

        DB::beginTransaction();

        // dd($request->has("video"));
        // upload video
        if($request->has("video")){
            $video = $this->uploadFile($request->video[0],env("SHOP_VIDEO_PATH"),$request->slug);
        }
        
        // shops table
        $shop = Shop::create([
            "guild_id" => $request->guild_id ,
            "name" => $request->name ,
            "slug" => $request->slug ,
            "email" => $request->email ,
            "video" => $request->has("video") ? $video : null ,
            "address" => $request->address ,
            "website" => $request->website ,
            "license" => $request->license ,
            "page_link" => $request->page_link ,
            "top_box_title" => $request->top_box_title ,
            "top_box_body" => $request->top_box_body ,
            "mid_box_title" => $request->mid_box_title ,
            "mid_box_body" => $request->mid_box_body ,
            "bot_box_title" => $request->bot_box_title ,
            "bot_box_body" => $request->bot_box_body ,
            "show_status" => 0 ,
            "stablished_at" => $request->stablished_at ,
        ]);


        // shop_social table
        foreach ($request->social_ids as $key => $social) {
            $shop->socials()->attach(Social::find($social),["link" => $request->social_links[$key]]);
        }

        // images table
        $images = new ImageController;
        $images->store($shop->id,$shop->slug,$request->banners,$request->top_image,$request->mid_image,$request->bot_right_image,$request->bot_left_image,$request->other_images);

        // phones table
        $images = new PhoneController;
        $images->store($shop->id,$request->phones);

        DB::commit();
        return $this->yresp(new ShopResource($shop->load("socials")->load("images")->load("phones")),201);
    }


    public function show(Shop $shop)
    {
        return $this->yresp(new ShopResource($shop->load("socials")->load("images")->load("phones")),200);
    }


    public function update(Request $request,Shop $shop)
    {
        $old_shop_slug=$shop->slug;

        $now = Jalalian::fromCarbon(Carbon::now())->getYear();
        $validator = Validator::make($request->all(),[
            // SHOP TABLE VALIDATIONS
            "guild_id" => "nullable|numeric",
            "name" => "nullable|string",
            "slug" => "nullable|string",
            "email" => "nullable|email",
            "video" => "nullable|max:1",
            "video.*" => "nullable|mimes:mp4,mkv|max:4096",
            "address" => "nullable|string",
            "website" => "nullable",
            "license" => "nullable",
            "page_link" => "nullable|unique:shops,page_link",
            "top_box_title" => "nullable|string",
            "top_box_body" => "nullable|string",
            "mid_box_title" => "nullable|string",
            "mid_box_body" => "nullable|string",
            "bot_box_title" => "nullable|string",
            "bot_box_body" => "nullable|string",
            "show_status" => "nullable",
            "stablished_at" => "nullable|numeric|max:$now",

            // SOCIAL TABLE VALIDATIONS => IN STORE METHOD OF SOCIALCONTROLLER
            "social_ids" => "nullable",
            "social_ids.*" => "nullable|numeric|distinct",
            "social_links" => "nullable",
            "social_links.*" => "nullable|string|distinct",

            // IMAGE TABLE VALIDATIONS
            "banners" => "nullable",
            "banners.*" => "image|mimes:png,jpg,jpeg|max:1024",
            "top_image" => "nullable|max:1",
            "top_image.*" => "image|mimes:png,jpg,jpeg|max:1024",
            "mid_image" => "nullable|max:1",
            "mid_image.*" => "image|mimes:png,jpg,jpeg|max:1024",
            "bot_right_image" => "nullable|max:1",
            "bot_right_image.*" => "image|mimes:png,jpg,jpeg|max:1024",
            "bot_left_image" => "nullable|max:1",
            "bot_left_image.*" => "image|mimes:png,jpg,jpeg|max:1024",
            "other_images" => "nullable",
            "other_images.*" => "image|mimes:png,jpg,jpeg|max:1024",

            // PHONE TABLE VALIDATIONS
            "phones" => "nullable",
            "phones.*" => "nullable|starts_with:0|max:11",
        ]);
        if($validator->fails()){
            return $this->nresp($validator->messages(),500);
        }

        DB::beginTransaction();

        // upload new video and delete old one
        
        if($request->has("video")){
            $video = $this->uploadFile($request->video[0],env("SHOP_VIDEO_PATH"),$shop->slug);
        }

        // shops table
        $shop->update([
            "guild_id" => $request->guild_id !== NULL ? $request->guild_id : $shop->guild_id ,
            "name" => $request->name !== NULL ? $request->name : $shop->name ,
            "slug" => $request->slug !== NULL ? $request->slug : $shop->slug ,
            "email" => $request->email !== NULL ? $request->email : $shop->email ,
            "video" => $request->has("video") ? $video : $shop->video ,
            "address" => $request->address !== NULL ? $request->address : $shop->address ,
            "website" => $request->website !== NULL ? $request->website : $shop->website ,
            "license" => $request->license !== NULL ? $request->license : $shop->license ,
            "page_link" => $request->page_link !== NULL ? $request->page_link : $shop->page_link ,
            "top_box_title" => $request->top_box_title !== NULL ? $request->top_box_title : $shop->top_box_title ,
            "top_box_body" => $request->top_box_body !== NULL ? $request->top_box_body : $shop->top_box_body ,
            "mid_box_title" => $request->mid_box_title !== NULL ? $request->mid_box_title : $shop->mid_box_title ,
            "mid_box_body" => $request->mid_box_body !== NULL ? $request->mid_box_body : $shop->mid_box_body ,
            "bot_box_title" => $request->bot_box_title !== NULL ? $request->bot_box_title : $shop->bot_box_title ,
            "bot_box_body" => $request->bot_box_body !== NULL ? $request->bot_box_body : $shop->bot_box_body ,
            "show_status" => $request->show_status !== NULL ? $request->show_status : $shop->show_status ,
            "stablished_at" => $request->stablished_at !== NULL ? $request->stablished_at : $shop->stablished_at ,
        ]);


        // shop_social table
        $current_socials=[];
        foreach ($shop->socials as $social){
            array_push($current_socials,$social->pivot->social_id);
        }
        foreach ($request->social_ids as $key => $social_id) {
            if(in_array($social_id,$current_socials)){
                $shop->socials()->detach(Social::find($social_id));
                $shop->socials()->attach(Social::find($social_id),["link" => $request->social_links[$key]]);
            }else{
                $shop->socials()->attach(Social::find($social_id),["link" => $request->social_links[$key]]);
            }
        }

        // // phones table
        if($request->phones !== NULL){
            $phones = new PhoneController;
            $phones->update($request->phones);
        }

        // rename shop folder name
        if($request->slug !== NULL){
            rename(env("SHOP_IMAGE_PATH")."/$old_shop_slug",env("SHOP_IMAGE_PATH")."/$request->slug");
            rename(env("SHOP_VIDEO_PATH")."/$old_shop_slug",env("SHOP_VIDEO_PATH")."/$request->slug");

            $images = new ImageController;
            $images->altUpdate($shop);
        }

        // images table
        if($request->slug !== NULL){
            $images = new ImageController;
            $images->update($shop->id,$shop->slug,$request->banners,$request->top_image,$request->mid_image,$request->bot_right_image,$request->bot_left_image,$request->other_images);
        }else{
            $images = new ImageController;
            $images->update($shop->id,$old_shop_slug,$request->banners,$request->top_image,$request->mid_image,$request->bot_right_image,$request->bot_left_image,$request->other_images);
        }
        DB::commit();
        return $this->yresp(new ShopResource($shop->load("socials")->load("images")->load("phones")),201);
    }


    public function destroy(Shop $shop)
    {
        File::deleteDirectory(public_path(env("SHOP_IMAGE_PATH"))."/$shop->slug");
        File::deleteDirectory(public_path(env("SHOP_VIDEO_PATH"))."/$shop->slug");
        $shop->delete();

        return response()->json([
            "status" => "success" ,
            "message" => "$shop->name shop successfully deleted" ,
        ], 200);
    }
}
