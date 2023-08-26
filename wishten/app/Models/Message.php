<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Message extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_sender',
        'content'
        
    ];
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

    
}