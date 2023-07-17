<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MissionMessaging extends Model
{
    use HasFactory;

    protected $table = 'mission_messagings';

    protected $casts = [
        'mission_id' => 'int',
        'mission_user_id' => 'int',
        'user_id' => 'int',
    ];

    protected $fillable = [
        'mission_id',
        'mission_user_id',
        'user_id',
        'status',
    ];

    /**
     * @return HasMany<Message>
     */
    public function message(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * @return BelongsTo<Mission, MissionMessaging>
     */
    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    /**
     * @return BelongsTo<User, MissionMessaging>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
