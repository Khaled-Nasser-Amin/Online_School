<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table='posts';
    protected $timestamp=true;
    protected $fillable=['post_file_name','school_id'];
    ############### relation #################

    public function school(){
        return $this->belongsTo('App\Models\School','school_id','post_id');
    }
}
