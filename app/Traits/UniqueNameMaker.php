<?php

namespace App\Traits;

use Carbon\Carbon;

trait UniqueNameMaker {
    public function uniqueName($file){
        $now = Carbon::now();
        $file = explode(".",$file);
        $extension = end($file);
        array_pop($file);
        $file = implode("-",$file);
        $newName = "$now->year-$now->month-$now->day-$now->hour-$now->minute-$now->second-$now->microsecond-$file.$extension";
        return $newName;
    }
}
