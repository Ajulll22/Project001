<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        $this->menu = "dashboard";
    }
    
    function index() {
        $data["menu"] = $this->menu;
        
        return view('index', $data);
    }
}
