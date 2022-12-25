<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $fillable = [
        'id',
        'name',
        'status',
        'question_id',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    // relations
    public function question(){
        return $this->belongsTo('App\Models\Question', 'question_id', 'id');
    }

    // get status and edit it
    public function getStatus(){
        return $this -> status == 0 ? 'false' : 'true';
    }
}
