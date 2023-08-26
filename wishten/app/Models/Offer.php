<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Offer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'salary',
        'description',
        'vacants',
        'document_path'
    ];

    /**
     * Da el usuario que subio la oferta(compania ya que solo este tipo de usuarios pueden subir ofertas)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Conversation::class, 'id_offer');
    }
}