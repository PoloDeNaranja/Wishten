<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    /**
     * Da uno de los dos usuarios de la conversacion
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user1');
    }
    /**
     * Da el otro de los dos usuarios de la conversacion
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user2');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_conversation');
    }
}