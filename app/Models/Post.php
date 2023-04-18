<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["category_id", "title", "image", "text", "is_published"];

    // # Relations

    public function category() {
        return $this->belongsTo(Category::class);
    }

    // # Mutators - date format
    

    protected function getUpdatedAtAttribute($value) {
        return date('d/m/Y H:i', strtotime($value));
    }

    protected function getCreatedAtAttribute($value) {
        return date('d/m/Y H:i', strtotime($value));
    }

    // # Getter

    public function getAbstract($max = 50) {
        return substr($this->text, 0, $max) . "...";
    }

    public function getImageUri() {
        return $this->image ? asset('storage/' . $this->image) : 'https://www.frosinonecalcio.com/wp-content/uploads/2021/09/default-placeholder.png';
    }

    // # Unique slug generation

    public static function generateUniqueSlug($title) {
        $slug = Str::of($title)->slug('-');
        
        $posts = Post::where('slug', $slug)->get();
        
        $i = 1;
        $original_slug = $slug;
        while(count($posts)) {
            $slug = $original_slug . "-" . ++$i;
            $posts = Post::where('slug', $slug)->get();
        }

        return $slug;
    }
}