<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timetableActivity extends Model
{
    protected $fillable = [];
    protected $table = 'timetable_schedule_activity_tags';
    use HasFactory;
}
