<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_pic',
        'ban',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the videos of a user.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'owner_id');
    }

    /**
     * Get the videos a user has viewed.
     */
    public function visualized_videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'visualized_videos', 'user_id', 'video_id')->withPivot('fav');
    }

    /**
     * Checks if a user has viewed the video given.
     */
    public function hasViewed(Video $video) {
        return $this->visualized_videos()->where('video_id', $video->id)->count() != 0;
    }

    /**
     * Get the followers of a user.
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    /**
     * Get the users followed by a user.
     */
    public function followed_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    /**
     * Get all the answers that a user has given to quizzes.
     */
    public function answers_given(): BelongsToMany
    {
        return $this->belongsToMany(Answer::class, 'user_answer', 'user_id', 'answer_id');
    }

    /**
     * Checks if a user is following another
     */
    public function isFollowing(User $user) {
        return $this->followed_users()->where('followed_id', $user->id)->count() != 0;
    }

    /**
     * Check if the user role is admin
     */
    public function isAdmin()
    {
        return $this->role == 'admin';
    }
}
