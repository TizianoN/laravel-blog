<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["category_id", "title", "image", "text", "is_published"];

    // protected $with = ['category', 'tags'];

    // # Relations

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function images() {
        return $this->hasMany(PostImage::class);
    }

    // # Mutators - date format
    

    protected function getUpdatedAtAttribute($value) {
        Carbon::setLocale('it');
        $date_from = Carbon::create($value);
        $date_now = Carbon::now();
        return str_replace('prima', 'fa', $date_from->diffForHumans($date_now));
    }

    protected function getCreatedAtAttribute($value) {
        Carbon::setLocale('it');
        $date_from = Carbon::create($value);
        $date_now = Carbon::now();
        return str_replace('prima', 'fa', $date_from->diffForHumans($date_now));
    }

    // # Getter

    public function getAbstract($max = 50) {
        return substr($this->text, 0, $max) . "...";
    }

    public function getImageUri() {
        return $this->image ? url('storage/' . $this->image) : 'https://www.frosinonecalcio.com/wp-content/uploads/2021/09/default-placeholder.png';
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