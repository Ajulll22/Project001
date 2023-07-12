<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantDetailModel extends Model
{
    use HasFactory;

    protected $table = "participant_details";

    protected $casts = [
        'created_at' => 'datetime:d:m:Y H:i:s',
        'updated_at' => 'datetime:d:m:Y H:i:s'
    ];

    protected $fillable = [
        "weight",
        "height",
        "participant_id",
        "event_id",
    ];

    public function event() {
        return $this->belongsTo(EventModel::class, "event_id", "id");
    }
}
