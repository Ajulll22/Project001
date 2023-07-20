<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantImmunizationModel extends Model
{
    use HasFactory;

    protected $table = "participant_immunizations";

    protected $casts = [
        'created_at' => 'datetime:d:m:Y H:i:s',
        'updated_at' => 'datetime:d:m:Y H:i:s'
    ];

    protected $fillable = [
        "participant_id",
        "immunization_id",
    ];

    public function detail()
    {
        return $this->belongsTo(ImmunizationModel::class, "immunization_id", "id");
    }
}
