<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'thumbnail',
        'is_active',
    ];

    /**
     * 1 Materi punya banyak Quiz
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
