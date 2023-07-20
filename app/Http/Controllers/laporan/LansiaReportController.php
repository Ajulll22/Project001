<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use Illuminate\Http\Request;

class LansiaReportController extends Controller
{
    public function __construct() {
        $this->menu = "laporan";
        $this->sub_menu = "lansia";
    }

    public function index() {
        $data["menu"] = $this->menu;
        $data["sub_menu"] = $this->sub_menu;

        $event_lists = EventModel::with(["Participants.detail.parent", "Participants.detail.immunizations.detail", "Participants" => function($q) {
            return $q->whereHas("detail", function($q) {
                $q->where("type", 3);
            });
        }])->whereHas("Participants.detail", function($query){
            return $query->where("type", 3);
        })->orderBy("event_day", "DESC")->get();

        $data["event_lists"] = $event_lists;
        return view("pages.laporan.lansia", $data);
    }
}
