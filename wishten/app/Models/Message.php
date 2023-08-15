<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    /**
     * Da el id de la conversaicón a la que pertenece el mensaje
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'id_conversation');
    }
    /**
     * Da el usuario que ha enviado el mensaje
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_sender');
    }
    /**
     * Da el usuario que ha recivido el mensaje
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_receiver');
    }
}