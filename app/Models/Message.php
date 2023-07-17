<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $casts = [
        'mission_messaging_id' => 'int',
        'user_id' => 'int',
    ];

    protected $fillable = [
        'mission_messaging_id',
        'user_id',
        'message',
    ];

    /**
     * @return BelongsTo<User, Message>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
