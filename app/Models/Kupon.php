<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'image',
        'discount',
        'type',
        'min_order',
        'valid_from',
        'valid_until',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'discount'    => 'integer',
        'type'       => 'string',
        'min_order'   => 'integer',
        'valid_from'  => 'date',
        'valid_until' => 'date',
        'usage_limit' => 'integer',
        'used_count'  => 'integer',
        'is_active'   => 'boolean',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? \Storage::url($this->image) : null;
    }

    public function getDiscountLabelAttribute()
    {
        return $this->type === 'percentage'
            ? $this->discount . '%'
            : 'Rp' . number_format($this->discount, 0, ',', '.');
    }

    public function getValidityAttribute()
    {
        if (!$this->valid_from && !$this->valid_until) return '-';
        $from = $this->valid_from ? date('d M Y', strtotime($this->valid_from)) : '...';
        $until = $this->valid_until ? date('d M Y', strtotime($this->valid_until)) : '...';
        return $from . ' — ' . $until;
    }
}
