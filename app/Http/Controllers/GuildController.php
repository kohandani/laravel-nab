<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use Illuminate\Http\Request;

class GuildController extends Controller
{

    public function index()
    {
        $guilds = Guild::all();
        return response()->json($guilds);
    }


    public function store(Request $request)
    {
        try {

            $image=$request->file("image");
            $name = explode(".",  $image->getClientOriginalName());
            $name[0] = $name[0].time();
            $name = implode(".",  $name);

            $image->move(storage_path(env("GUILD_IMAGES_PATH")), $name);

            Guild::create([
                "name" => $request->name,
                "slug" => $request->slug,
                "image" => $name,
            ]);
    
            return response()->json("success");

        } catch (\Throwable $th) {

            throw $th;
        }

    }


    public function show(guild $guild)
    {
        $guild = Guild::find($guild);
        return response()->json($guild);
    }


    public function update(Request $request, guild $guild)
    {
        dd($request->image);

        // if(){

        // }

        $guild->update([
            "name" => $request->name,
            "slug" => $request->slug,
            "image" => $name,
        ]);
    }


    public function destroy(guild $guild)
    {
        dd($guild);

        Guild::destroy($guild->id);
        return response()->json("guild deleted");
    }
}
