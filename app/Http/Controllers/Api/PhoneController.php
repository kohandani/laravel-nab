<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use App\Models\Phone;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PhoneController extends ApiController
{

    public function index()
    {
        //
    }


    public function store($shop_id,$phones)
    {
        foreach ($phones as $phone) {
            Phone::create([
                "shop_id" => $shop_id ,
                "phone_number" => $phone ,
            ]);
        }
    }


    public function show($id)
    {
        //
    }


    public function update($phones)
    {
        foreach ($phones as $key => $phone) {
            if($phone !== NULL){
                Phone::find($key)->update([
                    "phone_number" => $phone
                ]);
            }
        }
    }


    public function destroy($id)
    {
        //
    }
}
