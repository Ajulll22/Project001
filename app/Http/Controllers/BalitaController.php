<?php

namespace App\Http\Controllers;

use App\Models\ParentModel;
use App\Models\ParticipantModel;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function __construct() {
        $this->menu = "balita";
    }
    
    function index() {
        $data["menu"] = $this->menu;

        $list_participants = $this->get_data();
        $list_parents = ParentController::get_parent();

        $data["list_participants"] = $list_participants;
        $data["list_parents"] = $list_parents;
        return view('pages.balita', $data);
    }

    public function get_data() {
        $present = ParticipantModel::where("type", 1)->whereHas("detail.event", function ($query){
            return $query->where("event_day", "=", date("Y-m-d"));
        })->get();
        $not_present = ParticipantModel::where("type", 1)->doesntHave('detail')->orWhereHas("detail.event", function ($query){
            return $query->where("event_day", "!=", date("Y-m-d"));
        })->get();

        return [
            "present" => $present->toArray(),
            "not_present" => $not_present->toArray(),
        ];
    }
    
    public function store(Request $request){
        $data = $request->all();
        if ($request->input("full_name_parent")) {
            $parent = ParentModel::create([
                "full_name"=> $request->input("full_name_parent")
            ]);

            $data["parent_id"] = $parent->id;
            unset($data["full_name_parent"]);
        }
        $data["type"] = 1;

        ParticipantModel::create($data);

        return [
            "status" => "success",
            "title" => "Berhasil",
            "message" => "Berhasil menambahkan data",
            "data" => [
                "not_present" => $this->get_data()["not_present"],
                "parents" => ParentController::get_parent()
            ]
        ];
    }

    public function update(Request $request, ParticipantModel $participant) {
        $data = $request->all();
        if ($request->input("full_name_parent")) {
            $parent = ParentModel::create([
                "full_name"=> $request->input("full_name_parent")
            ]);

            $data["parent_id"] = $parent->id;
            unset($data["full_name_parent"]);
        }

        $participant->update($data);
        return [
            "status" => "success",
            "title" => "Berhasil",
            "message" => "Berhasil mengubah data",
            "data" => [
                "not_present" => $this->get_data()["not_present"],
                "parents" => ParentController::get_parent()
            ]
        ];
    }

    public function destroy(ParticipantModel $participant){
        $participant->delete();

        return [
            "status" => "success",
            "title" => "Berhasil",
            "message" => "Berhasil menghapus data",
            "data" => [
                "not_present" => $this->get_data()["not_present"],
            ]
        ];
    }
}
