<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiative extends Model
{
    protected $table= 'initiatives';
    protected $fillable = [
        'id',
        'name',
        'desc',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'  
    ];
    //relations 
    public function news(){
        return $this->hasMany('App\Models\News', 'initiative_id', 'id');
    }
}
