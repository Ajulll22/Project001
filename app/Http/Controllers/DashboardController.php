<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\ParticipantModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        $this->menu = "dashboard";
        $this->sub_menu = "";
    }
    
    function index() {
        $balita = ParticipantModel::where("type", 1)->count();
        $remaja = ParticipantModel::where("type", 2)->count();
        $lansia = ParticipantModel::where("type", 3)->count();

        $data = [
            "menu" => $this->menu,
            "sub_menu" => $this->sub_menu,
            "balita" => $balita,
            "remaja" => $remaja,
            "lansia" => $lansia,
        ];

        return view('index', $data);
    }
}
