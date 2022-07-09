<?php

namespace App\Models;

use App\Models\User;
use App\Models\Catalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'thumbnail',
        'published',
        'author_id',
        'catalog_id'
    ];

    public function catalog() {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }

    public function user() {
        return $this->hasMany(User::class, 'author_id');
    }
}
