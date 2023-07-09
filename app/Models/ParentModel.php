<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = "parents";

    protected $casts = [
        'created_at' => 'datetime:d:m:Y H:i:s',
        'updated_at' => 'datetime:d:m:Y H:i:s'
    ];

    protected $fillable = [
        "full_name",
    ];
}
