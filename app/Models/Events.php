<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table='events';
    protected $timestamp=false;
    protected $fillable=['event_file_name' , 'school_id','event_id'];
    ############# relations ################
    public function school(){
        return $this->belongsTo('App\Models\School','school_id','event_id');
    }
}
