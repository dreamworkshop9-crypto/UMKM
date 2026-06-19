<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasans';
    protected $fillable = [
        'pesanan_id',
        'user_id',
        'rating',
        'review',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    // Scopes untuk Admin
    public function scopeForAdmin(Builder $query)
    {
        return $query->with(['user', 'pesanan'])->orderBy('created_at', 'desc');
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', 'pending')->orderBy('created_at', 'asc');
    }

    public function scopeApproved(Builder $query)
    {
        return $query->where('status', 'approved')->orderBy('created_at', 'desc');
    }

    public function scopeRejected(Builder $query)
    {
        return $query->where('status', 'rejected')->orderBy('created_at', 'desc');
    }

    public function scopeByRating(Builder $query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeHighestRated(Builder $query)
    {
        return $query->orderBy('rating', 'desc');
    }

    public function scopeLowestRated(Builder $query)
    {
        return $query->orderBy('rating', 'asc');
    }

    // Accessors & Mutators
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    // Helper methods
    public function approve()
    {
        $this->update(['status' => 'approved']);
        return $this;
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
        return $this;
    }

    public function markAsPending()
    {
        $this->update(['status' => 'pending']);
        return $this;
    }
}