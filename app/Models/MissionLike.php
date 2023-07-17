<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionLike extends Model
{
    use HasFactory;

    protected $table = 'mission_likes';

    protected $casts = [
        'mission_id' => 'int',
        'user_id' => 'int',
    ];

    protected $fillable = [
        'mission_id',
        'user_id',
    ];

    /**
     * @return BelongsTo<Mission, MissionLike>
     */
    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }
}
