<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'parent_id'
    ];

    public function product() {
        return $this->hasMAny(Post::class);
    }
}
