<?php

namespace App\Models\ArSys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    protected $fillable = ['code', 'description'];
    protected $table = 'timetable_program';
    use HasFactory;

    public function department(){
        return $this->belongsTo(Department::class, 'department_id','id' );
    }
}
