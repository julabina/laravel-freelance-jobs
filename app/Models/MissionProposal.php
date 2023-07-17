<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionProposal extends Model
{
    use HasFactory;

    protected $table = 'mission_proposals';

    protected $casts = [
        'mission_id' => 'int',
        'user_id' => 'int',
    ];

    protected $fillable = [
        'mission_id',
        'user_id',
        'message',
        'status',
    ];

    /**
     * @return BelongsTo<User, MissionProposal>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Mission, MissionProposal>
     */
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}
