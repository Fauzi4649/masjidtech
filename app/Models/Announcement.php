<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'content', 'admin_id'];
    public function admin() { return $this->belongsTo(User::class, 'admin_id'); }
    public function media() { return $this->hasMany(MediaUpload::class); }
}