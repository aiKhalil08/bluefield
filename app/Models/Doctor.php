<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Doctor extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $guarded = ['id'];

    public function getNameAttribute() {
        return str($this->first_name.' '.$this->last_name)->title();
    }

    public function resolveRouteBinding($value, $field = null) {
        return $this->where('username', $value)->first();
    }

    public function contact(): MorphOne {
        return $this->morphOne(Contact::class, 'owner');
    }

    public function picture(): MorphOne {
        return $this->morphOne(Picture::class, 'owner');
    }
}
