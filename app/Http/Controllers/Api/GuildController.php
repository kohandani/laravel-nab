<?php

namespace App\Http\Controllers\Api;

use App\Models\Guild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Resources\GuildResource;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class GuildController extends ApiController
{

    public function index()
    {
        $guilds = Guild::all();
        return $this->yresp(GuildResource::collection($guilds),200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|string|unique:guilds,name",
            "slug" => "required|string|unique:guilds,slug",
            "image" => "required|max:1",
            "image.*" => "image|mimes:png,jpg|max:1024",
        ]);
        if($validator->fails()){
            return $this->nresp($validator->messages(),500);
        }

        DB::beginTransaction();
        $image = $this->uploadFile($request->image[0],env("GUILD_IMAGE_PATH"),$request->slug);
        $guild = Guild::create([
            "name" => $request->name,
            "slug" => $request->slug,
            "image" => $image,
            "show_status" => 0,
        ]);
        DB::commit();
        return $this->yresp(new GuildResource($guild),201);
    }


    public function show(Guild $guild)
    {
        return $this->yresp(new GuildResource($guild),200);
    }


    public function update(Request $request,Guild $guild)
    {
        $validator = Validator::make($request->all(),[
            "name" => "string|nullable",
            "slug" => "string|nullable",
            "image" => "max:1",
            "image.*" => "image|mimes:png,jpg|max:1024",
        ]);
        if($validator->fails()){
            return $this->nresp($validator->messages(),500);
        }

        DB::beginTransaction();

        // upload image
        if($request->has("image")){
            $image = $this->uploadFile($request->image[0],env("GUILD_IMAGE_PATH"),$guild->slug);
        }

        // rename guild folder name
        if($request->slug !== NULL){
            rename(env("GUILD_IMAGE_PATH")."/$guild->slug",env("GUILD_IMAGE_PATH")."/$request->slug");
        }


        $guild->update([
            "name" => $request->name !== NULL ? $request->name : $guild->name,
            "slug" => $request->slug !== NULL ? $request->slug : $guild->slug,
            "image" => $request->has("image") ? $image : $guild->image,
            "show_status" => $request->show_status !== NULL ? $request->show_status : $guild->show_status,
        ]);
        DB::commit();
        return $this->yresp(new GuildResource($guild),200);
    }


    public function destroy(Guild $guild)
    {
        DB::beginTransaction();
        $guild->delete();
        File::deleteDirectory(public_path(env("GUILD_IMAGE_PATH"))."/$guild->name");
        DB::commit();
        return $this->yresp(new GuildResource($guild),200);
    }
}