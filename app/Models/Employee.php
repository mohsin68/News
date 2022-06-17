<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table= 'employees';
    protected $fillable = [
        'id',
        'name',
        'government_id',
        'hierarchical_id',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'  
    ];
    // relations
    public function gallary(){
        return $this->hasOne('App\Models\Gallary', 'employee_id', 'id');
    }
    public function government(){
        return $this->belongsTo('App\Models\Government', 'government_id', 'id');
    }
    public function hierarchical(){
        return $this->belongsTo('App\Models\Hierarchical', 'hierarchical_id', 'id');
    }

}
