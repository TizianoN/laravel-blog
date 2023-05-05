<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // # Relations

    public function posts() {
        return $this->belongsToMany(Post::class);
    }

    // # HTML

    public function getBadgeHTML() {
        return '<span class="badge rounded-pill" style="background-color:' . $this->color . '">' . $this->label . '</span>';
    }
}