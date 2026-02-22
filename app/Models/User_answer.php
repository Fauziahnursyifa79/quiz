<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_answer extends Model
{
    // 1. Tambahkan ini untuk memastikan Laravel membaca tabel yang benar
    protected $table = 'user_answers';

    protected $fillable = [
        'result_id',
        'question_id',
        'selected_answer',
        'is_correct',
    ];

    /**
     * Relasi ke Result
     * Gunakan nama class yang konsisten dan foreign key eksplisit jika perlu
     */
    public function result()
    {
        return $this->belongsTo(Results::class, 'result_id');
    }

    /**
     * Relasi ke Question
     */
    public function question()
    {
        return $this->belongsTo(Questions::class, 'question_id');
    }
}
