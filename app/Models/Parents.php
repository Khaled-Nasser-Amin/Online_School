<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Parents extends Authenticatable
{
    use HasFactory,Notifiable;
    protected $table='parents';
    protected $primaryKey="ID";
    protected $timestamp=true;
    protected $fillable = [
        'first_name','last_name', 'email', 'password', 'phone',
        'image','ID','local_address','par_reg_code',
        'gender','birthday','school_name'
    ];
    protected $hidden = [
        'remember_token'
    ];
    ######################################## relations ############################
    public function student(){
        return $this->hasMany('App\Models\Student','parent_id','ID');
    }
    public function school(){
        return $this->belongsTo('App\Models\School','school_id','ID');
    }
}
