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
    public static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
            $user->student()->dissociate()->save();
            // do the rest of the cleanup...
        });
    }
    public function events(){
        return $this->hasManyThrough('App\Models\Events','App\Models\School','ID','school_id','school_id','ID');
    }
}
