<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $fillable = [
        'quiz_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'score', // tambahkan kolom score
    ];

    /**
     * 1 Question milik 1 Quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * 1 Question punya banyak UserAnswer
     */
    public function userAnswers()
    {
        return $this->hasMany(User_answer::class);
    }
}
