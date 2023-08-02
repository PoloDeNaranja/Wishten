<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Video extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'video_path',
        'thumb_path',
        'status'
    ];

    /**
     * Obtiene el usuario que creó el vídeo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Obtiene las visitas al vídeo
     */
    public function views(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'visualized_videos', 'video_id', 'user_id')->withPivot('fav', 'correct_answers');
    }

    /**
     * Comprueba si el usuario '$user' marcó este vídeo como favorito
     */
    public function isFav(User $user) {
        return $this->views()->where('user_id', $user->id)->first()->pivot->fav;
    }

    /**
     * Obtiene el número de usuarios que marcaron este vídeo como favorito
     */
    public function numberOfFavs() {
        return $this->views()->where('fav', 1)->count();
    }

    /**
     * Obtiene el número de respuestas correctas que un usuario ha dado al vídeo
     */
    public function correctAnswers(User $user) {
        return $this->views()->where('user_id', $user->id)->first()->pivot->correct_answers;
    }

    /**
     * Obtiene el número de preguntas (sin contar las anotaciones, es decir, las preguntas sin respuestas)
     */
    public function numberOfQuestions() {
        $questions_count = 0;
        foreach ($this->questions as $question) {
            if($question->answers->count() > 0) {
                $questions_count++;
            }
        }
        return $questions_count;
    }

    /**
     * Obtiene la última puntuación de un usuario, en porcentaje
     */
    public function userScore(User $user) {
        return $this->correctAnswers($user)/$this->numberOfQuestions()*100;
    }

    /**
     * Obtiene el tema del vídeo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Obtiene las preguntas correspondientes a este vídeo (contando las anotaciones)
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'video_id');
    }
}
