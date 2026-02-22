<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'materi_id',
        'title',
        'description',
        'time_limit',
        'passing_score',
        'is_active',
    ];

    /**
     * 1 Quiz milik 1 Materi
     */
    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    /**
     * 1 Quiz punya banyak Question
     */
    public function questions()
    {
        return $this->hasMany(Questions::class);
    }

    /**
     * 1 Quiz punya banyak Result
     */
    public function results()
    {
        return $this->hasMany(Results::class);
    }
}
