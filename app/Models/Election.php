<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'description',
        'start_at',
        'end_at',
        'status',
        'results_published',
    ];

    protected function casts(): array
    {
        return [
            'start_at'          => 'datetime',
            'end_at'            => 'datetime',
            'results_published' => 'boolean',
        ];
    }

    // ─── Relationships ────────────────────────────────────

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class)->orderBy('order');
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

    public function isOngoing(): bool
    {
        return $this->status === 'ongoing';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function resultsVisible(): bool
    {
        return $this->status === 'closed' && $this->results_published === true;
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }
}