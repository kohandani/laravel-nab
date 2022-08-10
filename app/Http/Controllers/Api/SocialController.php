<?php

namespace App\Http\Controllers\Api;

use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SocialResource;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class SocialController extends ApiController
{

    public function index()
    {
        $socials = Social::all();
        return $this->yresp(SocialResource::collection($socials),200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|string",
            "icon" => "required|string",
        ]);
        if($validator->fails()){
            return $this->nresp($validator->messages(),500);
        }

        DB::beginTransaction();
        $social = Social::create([
            "name" => $request->name ,
            "icon" => $request->icon ,
        ]);
        DB::commit();
        return $this->yresp(new SocialResource($social),201);
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, Social $social)
    {
        $validator = Validator::make($request->all(),[
            "name" => "nullable|string",
            "icon" => "nullable|string",
        ]);
        if($validator->fails()){
            return $this->nresp($validator->messages(),500);
        }

        DB::beginTransaction();
        $social->update([
            "name" => $request->name !== NULL ? $request->name : $social->name ,
            "icon" => $request->icon !== NULL ? $request->icon : $social->icon ,
        ]);
        DB::commit();
        return $this->yresp(new SocialResource($social),201);
    }


    public function destroy(Social $social)
    {
        $social->delete();

        return response()->json([
            "status" => "success" ,
            "message" => "$social->name social media successfully deleted" ,
        ], 200);
    }
}
