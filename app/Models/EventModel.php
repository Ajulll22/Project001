<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    use HasFactory;

    protected $table = "events";

    protected $casts = [
        'created_at' => 'datetime:d:m:Y H:i:s',
        'updated_at' => 'datetime:d:m:Y H:i:s'
    ];

    protected $fillable = [
        "event_day"
    ];
}
