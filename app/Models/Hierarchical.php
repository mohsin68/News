<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hierarchical extends Model
{
    protected $table= 'hierarchical_structure';
    protected $fillable = [
        'id',
        'position',
        'parent',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'  
    ];
    //relations

    public function employee(){
        return $this->hasMany('App\Models\Employee', 'hierarchical_id', 'id');
    }
    public function parent() {
        return $this->belongsTo('App\Models\Hierarchical', 'parent'); //get parent category
    }
    
    public function children() {
        return $this->hasMany('App\Models\Hierarchical', 'parent'); //get all subs. NOT RECURSIVE
    }
}
