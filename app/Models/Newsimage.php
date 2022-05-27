<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsimage extends Model
{
    protected $table = 'newsimages';
    protected $fillable = [
        'id',
        'name',
        'news_i_id',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function news(){
        return $this->BelongsTo('App\Models\News', 'news_i_id', 'id');
    }
}
