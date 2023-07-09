<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_details', function (Blueprint $table) {
            $table->id();
            $table->float("weight");
            $table->float("height");
            $table->boolean("immunization")->default(0);
            $table->boolean("vit")->default(0);
            $table->foreignId("participant_id")->references("id")->on("participants")->onDelete("cascade");
            $table->foreignId("event_id")->references("id")->on("events")->onDelete("cascade");
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
        Schema::dropIfExists('participant_detail');
    }
}
