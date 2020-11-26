<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use HasFactory;


    protected $casts = [
        "theme" => "array"
    ];

    protected $fillable = [
        "name",
        "bio",
        "profile_image",
        'theme'
    ];
    // functions to get/manipulate band members
    public function getMembers()
    {
        return $this->belongsToMany(User::class, 'band_user');
    }
    public function addMember($memberId) {
        $this->getMembers()->syncWithoutDetaching($memberId);
    }
    public function removeMember($memberId) {
        $this->getMembers()->detach($memberId);
    }

    // functions to get/manipulate posts
    public function getPosts() {
        return $this->hasMany('App\Models\Post');
    }
    public function getLatestPosts() {
        return $this->getPosts()->latest()->limit(4);
    }


    public function saveProfileImage($img) {

        $img_name = isset($this->profile_image) ? uniqid('profile_picture_').".jpg" : basename($this->profile_img);
        $this->profile_image = $img->storeAs('bands', $img_name, 'profileImages');
    }
}
