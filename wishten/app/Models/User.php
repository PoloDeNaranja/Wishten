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
    public function visualized_videos(): HasMany
    {
        return $this->hasMany(Visualized_videos::class, 'user_id');
    }

    /**
     * Get the followers of a user.
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    /**
     * Get the followers of a user.
     */
    public function followed_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function isFollowing(User $user) {
        return $this->followed_users()->where('followed_id', $user->id)->count() === 0;
    }

    /**
     * Check if the user role is admin
     */
    public function isAdmin()
    {
        return $this->role == 'admin';
    }
}
