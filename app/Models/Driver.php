<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    //
    protected $fillable = ['name','vehicle','password','username','phone'];

    public function requests()
    {
        return $this->hasMany(Route::class,'assigned_to');
    }
}
