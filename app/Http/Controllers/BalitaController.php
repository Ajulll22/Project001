<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\ImmunizationModel;
use App\Models\ParentModel;
use App\Models\ParticipantDetailModel;
use App\Models\ParticipantImmunizationModel;
use App\Models\ParticipantModel;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function __construct() {
        $this->menu = "balita";
        $this->sub_menu = "";
    }
    
    function index() {
        $data["menu"] = $this->menu;
        $data["sub_menu"] = $this->sub_menu;

        $list_participants = $this->get_data();
        $list_parents = ParentController::get_parent();
        $list_immunizations = ImmunizationModel::where("type", 1)->get();

        // dd($list_participants);

        $data["list_participants"] = $list_participants;
        $data["list_parents"] = $list_parents;
        $data["list_immunizations"] = $list_immunizations;
        return view('pages.balita', $data);
    }

    public function get_data() {
        $present = ParticipantModel::with("detail", "immunizations")->where("type", 1)->whereHas("detail.event", function ($query){
            return $query->where("event_day", "=", date("Y-m-d"));
        })->get();
        $not_present = ParticipantModel::with("detail", "immunizations")->where(function ($query1) {
            $query1->doesntHave('detail')->orWhereHas("detail.event", function ($query2){
                return $query2->where("event_day", "!=", date("Y-m-d"));
            });
        })->where("type", 1)->get();

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

    public function present(Request $request) 
    {
        $data = $request->all();
        $participantDetail = [
            "weight" => $data["weight"],
            "height" => $data["height"],
            "participant_id" => $data["participant_id"],
        ];

        $event = EventModel::where("event_day", date("Y-m-d"))->get();
        if (!count($event)) {
            $event = EventModel::create([ "event_day" => date("Y-m-d") ]);
            $participantDetail["event_id"] = $event->id;
        } else {
            $participantDetail["event_id"] = $event[0]->id;
        }

        ParticipantDetailModel::create($participantDetail);
        ParticipantImmunizationModel::where("participant_id", $data["participant_id"])->delete();
        
        $tmp_immunizations = [];
        if (array_key_exists("immunizations", $data)) {
            foreach ($data["immunizations"] as $val) {
                array_push($tmp_immunizations, [
                    "participant_id" => $data["participant_id"],
                    "immunization_id" => $val,
                    "created_at" => now(),
                    "updated_at" => now()
                ]);
            }
        }
        if (count($tmp_immunizations)) {
            ParticipantImmunizationModel::insert($tmp_immunizations);
        }

        $list_participants = $this->get_data();

        return [
            "status" => "success",
            "title" => "Berhasil",
            "message" => "Berhasil menambah data",
            "data" => [
                "not_present" => $list_participants["not_present"],
                "present" => $list_participants["present"],
            ]
        ];
    }

    public function present_update(Request $request, ParticipantDetailModel $detail) 
    {
        $data = $request->all();

        $detail->update([
            "weight" => $data["weight"],
            "height" => $data["height"]
        ]);

        ParticipantImmunizationModel::where("participant_id", $detail->participant_id)->delete();
        
        $tmp_immunizations = [];
        if (array_key_exists("immunizations", $data)) {
            foreach ($data["immunizations"] as $val) {
                array_push($tmp_immunizations, [
                    "participant_id" => $detail->participant_id,
                    "immunization_id" => $val,
                    "created_at" => now(),
                    "updated_at" => now()
                ]);
            }
        }
        if (count($tmp_immunizations)) {
            ParticipantImmunizationModel::insert($tmp_immunizations);
        }

        return [
            "status" => "success",
            "title" => "Berhasil",
            "message" => "Berhasil mengubah data",
            "data" => [
                "present" => $this->get_data()["present"],
            ]
        ];
    }
}
