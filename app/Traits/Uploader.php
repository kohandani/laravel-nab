<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Traits\UniqueNameMaker;

trait Uploader {

    use UniqueNameMaker;

    public function uploadFile($file,$file_path,$optional_path=NULL){
        $newName = $this->uniqueName($file->getclientoriginalname());
        $file->move(public_path($file_path)."/$optional_path",$newName);
        return $newName;
    }
}
