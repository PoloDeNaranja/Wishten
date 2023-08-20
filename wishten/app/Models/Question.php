<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'question_time'
    ];

    /**
     * Obtiene el vídeo al que pertenece esta pregunta
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    /**
     * Obtiene las respuestas a esta pregunta
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    /**
     * Obtiene el número de respuestas correctas a esta pregunta
     */
    public function correctAnswers() {
        $correct_count = 0;
        foreach($this->answers as $answer) {
            if($answer->is_correct === 1) {
                $correct_count++;
            }
        }
        return $correct_count;
    }

}
