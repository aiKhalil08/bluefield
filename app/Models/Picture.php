<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Picture extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $guarded = ['id'];

    public function owner(): MorphTo {
        return $this->morphTo();
    }
}
