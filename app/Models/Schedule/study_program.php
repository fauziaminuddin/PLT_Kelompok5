<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class study_program extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'description'];
    protected $table = 'arsys_study_program';
}
