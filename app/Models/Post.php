<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [ 'id' ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        return url(Storage::url($this->file));
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
