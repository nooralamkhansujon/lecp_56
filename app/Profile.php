<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Country;
use App\State;
use App\City;

class Profile extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded =[];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function users()
    {
       return $this->belongsToMany(User::class,'user_id','id');
    }

    public function  country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
     
    public function  state()
    {
        return $this->belongsTo(State::class,'state_id','id');
    }

    public function  city()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }
    
   
}

