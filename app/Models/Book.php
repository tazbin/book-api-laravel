<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'page',
        'writter_id'
    ];

    public function writter()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}
