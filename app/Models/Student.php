<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, notifiable;

    protected $table = 'student';
    protected $primaryKey = "ID";

    protected $timestamp = true;
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone',
        'image', 'ID', 'subject', 'local_address', 'st_reg_code',
        'gender', 'grade', 'birthday', 'parent_code', 'school_name'
    ];
    protected $hidden = [
        'remember_token'
    ];

    ######################## relations #########################
    public function school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'ID');
    }

    public function teacher()
    {
        return $this->belongsToMany('App\Models\Teacher', 'teach_for', 'student_id', 'teacher_id', 'ID', 'ID')->withPivot('subject');
    }

    public function parents()
    {
        return $this->belongsTo('App\Models\Parents', 'parent_id', 'ID');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) { // before delete() method call this
            $user->teacher()->detach();
            // do the rest of the cleanup...
        });
    }

    public function events()
    {
        return $this->hasManyThrough('App\Models\Events', 'App\Models\School', 'ID', 'school_id', 'school_id', 'ID');
    }
}
