<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;



class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_company'
    ];
    /**
     * Da uno de los dos usuarios de la conversacion
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    /**
     * Da el otro de los dos usuarios de la conversacion
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_company');
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'id_offer');
    }
    /**
     * Relacion entre la tabla messages y la tabla conversations, una conversacion puede tener varios mensajes asociados,así puedo obtener todos los mensajes de una conversación $messages = $conversation->messages;
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'id_conversation');
    }

}
