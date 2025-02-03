<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['name','notes'];


    public function requests()
    {
        return $this->hasMany(UserRequest::class,'assigned_to');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class,'assigned_to');
    }

}
