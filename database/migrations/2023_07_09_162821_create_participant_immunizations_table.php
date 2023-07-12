<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantImmunizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_immunizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("participant_id")->references("id")->on("participants")->onDelete("cascade");
            $table->foreignId("immunization_id")->references("id")->on("immunizations")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_immunizations');
    }
}
