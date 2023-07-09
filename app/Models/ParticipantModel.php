<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantModel extends Model
{
    use HasFactory;

    protected $table = "participants";

    protected $casts = [
        'created_at' => 'datetime:d:m:Y H:i:s',
        'updated_at' => 'datetime:d:m:Y H:i:s'
    ];

    protected $fillable = [
        "full_name",
        "type",
        "gender",
        "birthday",
        "address",
        "parent_id"
    ];

    public function detail()
    {
        return $this->hasOne(ParticipantDetail::class, "participant_id", "id")->latestOfMany();
    }
}
