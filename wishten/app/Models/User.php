<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;


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
     * Obtiene los vídeos de un usuario
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'owner_id');
    }

    /**
     * Obtiene los vídeos que ha visto un usuario
     */
    public function visualized_videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'visualized_videos', 'user_id', 'video_id')->withPivot('fav');
    }

    /**
     * Comprueba si el usuario ha visto el vídeo que se pasa como parámetro
     */
    public function hasViewed(Video $video) {
        return $this->visualized_videos()->where('video_id', $video->id)->count() != 0;
    }

    /**
     * Obtiene los seguidores del usuario
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withPivot('followed_at');
    }

    /**
     * Obtiene los usuarios a los que sigue este usuario
     */
    public function followed_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withPivot('followed_at');
    }

    /**
     * Comprueba si el usuario está siguiendo al que se pasa como parámetro
     */
    public function isFollowing(User $user) {
        return $this->followed_users()->where('followed_id', $user->id)->count() != 0;
    }

    /**
     * Obtiene todas las respuestas que ha dado el usuario a los cuestionarios que ha realizado
     */
    public function answers_given(): BelongsToMany
    {
        return $this->belongsToMany(Answer::class, 'user_answer', 'user_id', 'answer_id');
    }

     /**
     * Obtiene la respuesta que un usuario ha dado a una pregunta concreta
     */
    public function hasAnswered(Question $question) {

        foreach($this->answers_given()->get() as $answer) {
            if($answer->question->id == $question->id) {
                return $answer;
            }
        }
        return false;
    }

    /**
     * Obtiene el número total de favoritos sumando todos los vídeos del usuario
     */
    public function totalFavs() {
        $total_favs = 0;
        foreach($this->videos as $video) {
            $total_favs += $video->numberOfFavs();
        }
        return $total_favs;
    }

    /**
     * Comprueba si el usuario tiene el rol de administrador
     */
    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    /**
     * Relaciona tabla user con messages permitiendome obtener los mensajes que ha enviado un usuario $user = User::find(id) $sentMessages = $user->sentMessages;
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'id_sender');
    }

    //offers has many

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'owner_id');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'id_user');
    }
}
