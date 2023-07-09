<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public static function get_parent() {
        $list = DB::table("parents")->select(DB::raw("id, full_name as text"))->get();
        
        return $list->toArray();
    }
}
