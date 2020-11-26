<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
      'band_id',
      'video_url'
    ];

    public function getBand() {
        return $this->belongsTo('App\Models\Band')->get();
    }
}
