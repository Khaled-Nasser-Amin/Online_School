<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Teach_For extends Pivot
{
    use HasFactory;
    protected $table='teach_for';
    protected $fillable=['student_id' ,'teacher_id','subject'];
}
