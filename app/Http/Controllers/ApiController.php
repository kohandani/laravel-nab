<?php

namespace App\Http\Controllers;

use App\Traits\Uploader;
use App\Traits\Responser;
use Illuminate\Http\Request;
use App\Traits\UniqueNameMaker;

class ApiController extends Controller
{
    use Responser;
    use Uploader;
}
