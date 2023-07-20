<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        $this->menu = "dashboard";
        $this->sub_menu = "";
    }
    
    function index() {
        $data["menu"] = $this->menu;
        $data["sub_menu"] = $this->sub_menu;
        
        return view('index', $data);
    }
}
