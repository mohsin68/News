<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $table = 'governorates';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name'
    ];
    public function news(){
        return $this->hasMany('App\Models\News', 'governorate_id', 'id');
    }
}
