<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Answer extends Model
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
        'is_correct'
    ];

    /**
     * Devuelve la pregunta correspondiente a esta respuesta
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Devuelve todos los usuarios que seleccionaron esta respuesta al cuestionario
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_answer', 'answer_id', 'user_id');
    }

}
