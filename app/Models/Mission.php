<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mission extends Model
{
    use HasFactory;
    use Softdeletes;

    protected $casts = [
        'user_id' => 'int',
        'proposal_count' => 'int',
        'remote' => 'bool',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'remuneration',
        'proposal_count',
        'remote',
        'postalcode',
        'city',
        'status',
    ];

    /**
     * @return BelongsTo<User, Mission>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*  public function mission_like(): HasMany
     {
         return $this->hasMany(MissionLike::class);
     }

     public function mission_proposal(): HasMany
     {
         return $this->hasMany(MissionProposal::class);
     } */
}
