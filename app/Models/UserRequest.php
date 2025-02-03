<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $table='requests';
    //
    protected $fillable = ['name','category', 'lat', 'lon','phone','info','isCompleted','bonus','address'];

    public function route(){
        return $this->belongsTo(Route::class,'assigned_to');
    }
}
