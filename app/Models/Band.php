<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use HasFactory;


    public function getMembers()
    {
        return $this->belongsToMany(User::class, 'band_user');
    }

    public function addMember($id) {
        $this->getMembers()->syncWithoutDetaching($id);
    }

    public function getPosts() {
        return $this->hasMany('App\Models\Post');
    }
}
