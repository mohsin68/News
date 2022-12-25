<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = [
        'id',
        'name',
        'exam_id',
        'type',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    // relations
    public function exam(){
        return $this->belongsTo('App\Models\Exam', 'exam_id', 'id');
    }
    public function answer(){
        return $this->hasMany('App\Models\Answer', 'question_id', 'id');
    }
}
