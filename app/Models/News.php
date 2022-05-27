<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = [
        'id',
        'name',
        'desc',
        'user',
        'link',
        'const',
        'status',
        'governorate_id',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // get status and edit it
    public function getStatus(){
        return $this -> status == 0 ? 'News' : 'Article';
    }
    // relations
    public function governorate(){
        return $this->belongsTo('App\Models\Governorate', 'governorate_id', 'id');
    }
    public function source(){
        return $this->hasMany('App\Models\Source', 'news_s_id', 'id');
    }
    public function newsimg(){
        return $this->hasMany('App\Models\Newsimage', 'news_i_id', 'id');
    }
    public function words(){
        return $this->hasMany('App\Models\Word', 'news_w_id', 'id');
    }
}
