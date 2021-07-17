<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_message_id',
    ];

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
