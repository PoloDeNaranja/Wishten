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
     * Get the user that owns the video.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the views of the video.
     */
    public function views(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'visualized_videos', 'video_id', 'user_id')->withPivot('fav', 'correct_answers');
    }

    /**
     * Checks if the user marked this video as fav
     */
    public function isFav(User $user) {
        return $this->views()->where('user_id', $user->id)->first()->pivot->fav;
    }

    /**
     * Get the number of users that marked this video as fav
     */
    public function numberOfFavs() {
        return $this->views()->where('fav', 1)->count();
    }

    /**
     * Get the number of correct answers for a user
     */
    public function correctAnswers(User $user) {
        return $this->views()->where('user_id', $user->id)->first()->pivot->correct_answers;
    }

    /**
     * Get the score of a user
     */
    public function userScore(User $user) {
        return $this->correctAnswers($user)/$this->questions->count()*100;
    }

    /**
     * Get the subject of the video.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Get the questions of a video.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'video_id');
    }
}
