<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'correct_answers',
        'is_passed',
    ];

    /**
     * 1 Result milik 1 User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 1 Result milik 1 Quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * 1 Result punya banyak UserAnswer
     */
    public function userAnswers()
    {
        return $this->hasMany(User_answer::class);
    }
}
