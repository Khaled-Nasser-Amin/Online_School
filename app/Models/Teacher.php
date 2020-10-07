<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use HasFactory,notifiable;
    protected $table='teacher';
    protected $primaryKey="ID";
    protected $timestamp=true;
    protected $fillable = [
        'first_name','last_name', 'email', 'password', 'phone',
        'image','ID','subject','local_address','tea_reg_code',
        'gender','grade','birthday','school_name'
    ];
    protected $hidden = [
        'remember_token'
    ];

    ################################### Relations #############################
    public function student(){
        return $this->belongsToMany('App\Models\Student','teach_for','teacher_id','student_id','ID','ID')->withPivot('subject');
    }
    public function school(){
        return $this->belongsTo('App\Models\School','school_id','ID');
    }
    public static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
            $user->student()->detach();
            // do the rest of the cleanup...
        });
    }
    public function events(){
        return $this->hasManyThrough('App\Models\Events','App\Models\School','ID','school_id','school_id','ID');
    }

}
