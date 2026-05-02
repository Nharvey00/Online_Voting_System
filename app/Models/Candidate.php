<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'election_id',
        'position_id',
        'platform',
        'document',
        'status',
        'remarks',
    ];

    // ─── Relationships ────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // ─── Helpers ──────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    // Total votes this candidate received
    public function totalVotes(): int
    {
        return $this->votes()->count();
    }
}