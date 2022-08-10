<?php

namespace App\Traits;

trait Responser {
    public function yresp($data,$code){
        return response()->json([
            "status" => "success",
            "data" => $data,
        ], $code);
    }
    public function nresp($message,$code){
        return response()->json([
            "status" => "failed",
            "message" => $message,
        ], $code);
    }
}
