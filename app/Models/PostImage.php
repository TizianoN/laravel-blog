<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;
    
    public $fillable = ['post_id', 'title', 'image', 'content'];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function getImageUri() {
        return $this->image ? url('storage/' . $this->image) : 'https://www.frosinonecalcio.com/wp-content/uploads/2021/09/default-placeholder.png';
    }
}