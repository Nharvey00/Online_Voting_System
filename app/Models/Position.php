<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'name',
        'max_winners',
        'order',
    ];

    // ─── Relationships ────────────────────────────────────

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // ─── Helpers ──────────────────────────────────────────

    // Get only approved candidates for this position
    public function approvedCandidates()
    {
        return $this->candidates()->where('status', 'approved');
    }

    // Total votes cast for this position
    public function totalVotes(): int
    {
        return $this->votes()->count();
    }
}