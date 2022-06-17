<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    protected $table= 'governments';
    protected $fillable = [
        'id',
        'name',
        'registration_status',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'  
    ];
    //relations 
    public function news(){
        return $this->hasMany('App\Models\News', 'government_id', 'id');
    }
    public function employee(){
        return $this->hasMany('App\Models\Employee', 'government_id', 'id');
    }
}
