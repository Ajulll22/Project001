<?php

namespace Database\Seeders;

use App\Models\ImmunizationModel;
use Illuminate\Database\Seeder;

class ImmunizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "BCG Polio 1",
                "type" => 1,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
            [
                "name" => "DPT-HB-Hib 1 Polio 2",
                "type" => 1,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
            [
                "name" => "DPT-HB-Hib 2 Polio 3",
                "type" => 1,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
            [
                "name" => "DPT-HB-Hib 3 Polio 4",
                "type" => 1,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
            [
                "name" => "Campak",
                "type" => 1,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
            [
                "name" => "Campak Rubella",
                "type" => 2,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
            [
                "name" => "Tethanus Diphteria",
                "type" => 2,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
            [
                "name" => "Cek Gula Darah",
                "type" => 3,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
            [
                "name" => "Cek Kolesterol",
                "type" => 3,
                "created_at" =>now(),
                "updated_at" =>now()
            ],
        ];

        ImmunizationModel::insert($data);
    }
}
