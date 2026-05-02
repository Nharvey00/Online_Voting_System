<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'birthdate',
        'address',
        'barangay',
        'city',
        'province',
        'id_type',
        'id_number',
        'id_photo',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'password'  => 'hashed',
        ];
    }

    // Relationships
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Helper — is this user an approved candidate in any election?
    public function isCandidate(): bool
    {
        return $this->candidates()
                    ->where('status', 'approved')
                    ->exists();
    }

    // Helper — is this user an approved candidate in a specific election?
    public function isCandidateIn(int $electionId): bool
    {
        return $this->candidates()
                    ->where('election_id', $electionId)
                    ->where('status', 'approved')
                    ->exists();
    }

    // Helper — has this user already voted in a specific election for a specific position?
    public function hasVotedFor(int $electionId, int $positionId): bool
    {
        return $this->votes()
                    ->where('election_id', $electionId)
                    ->where('position_id', $positionId)
                    ->exists();
    }
}