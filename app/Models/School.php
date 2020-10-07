<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class School extends Authenticatable
{
    use HasFactory,notifiable;

    protected $table = "school";
    protected $primaryKey="ID";

    protected $timestamp=true;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'location',
        'st_reg_code', 'te_reg_code', 'par_reg_code', 'image',
        'ID','subject_name'
    ];
    protected $hidden = [
        'remember_token'
    ];


    ################# relations   ###############
    public function student(){
        return $this-> hasMany('App\Models\Student','school_id','ID');
    }
    public function teacher(){
        return $this->hasMany('App\Models\Teacher','school_id','ID');
    }
    public function parents(){
        return $this->hasMany('App\Models\Parents','school_id','ID');
    }
    public function events(){
        return $this->hasMany('App\Models\Events','school_id','ID');
    }
    public function posts(){
        return $this->hasMany('App\Models\Posts','school_id','ID');
    }

}
